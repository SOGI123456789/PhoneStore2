<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PromotionController extends Controller
{
    // Hiển thị danh sách khuyến mại
    public function index()
    {
        $promotions = Promotion::with(['products', 'categories'])
                               ->orderBy('created_at', 'desc')
                               ->paginate(10);

        return view('promotions.index', compact('promotions'));
    }

    // Hiển thị form tạo khuyến mại
    public function create()
    {
        $products = Product::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();

        return view('promotions.create', compact('products', 'categories'));
    }

    // Lưu khuyến mại mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:promotions,code',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'applies_to' => 'required|in:all,specific_products,specific_categories',
            'usage_limit' => 'nullable|integer|min:1',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ], [
            'code.unique' => 'Mã khuyến mại đã tồn tại',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
        ]);

        // Validation cho discount_value
        if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
            return back()->withErrors(['discount_value' => 'Phần trăm giảm giá không được vượt quá 100%']);
        }

        $promotion = Promotion::create([
            'title' => $request->title,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'applies_to' => $request->applies_to,
            'usage_limit' => $request->usage_limit,
            'min_order_value' => $request->min_order_value,
            'max_discount_amount' => $request->max_discount_amount,
            'is_active' => true,
        ]);

        // Liên kết với sản phẩm
        if ($request->applies_to === 'specific_products' && $request->products) {
            $promotion->products()->attach($request->products);
        }

        // Liên kết với danh mục
        if ($request->applies_to === 'specific_categories' && $request->categories) {
            $promotion->categories()->attach($request->categories);
        }

        return redirect()->route('promotions.index')
                        ->with('success', 'Khuyến mại đã được tạo thành công!');
    }

    // Hiển thị chi tiết khuyến mại
    public function show(Promotion $promotion)
    {
        $promotion->load(['products', 'categories', 'usages.user', 'usages.order']);
        
        return view('promotions.show', compact('promotion'));
    }

    // Hiển thị form chỉnh sửa
    public function edit(Promotion $promotion)
    {
        $products = Product::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();
        $promotion->load(['products', 'categories']);

        return view('promotions.edit', compact('promotion', 'products', 'categories'));
    }

    // Cập nhật khuyến mại
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:promotions,code,' . $promotion->id,
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'applies_to' => 'required|in:all,specific_products,specific_categories',
            'usage_limit' => 'nullable|integer|min:1',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
            return back()->withErrors(['discount_value' => 'Phần trăm giảm giá không được vượt quá 100%']);
        }

        $promotion->update([
            'title' => $request->title,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'applies_to' => $request->applies_to,
            'usage_limit' => $request->usage_limit,
            'min_order_value' => $request->min_order_value,
            'max_discount_amount' => $request->max_discount_amount,
            'is_active' => $request->has('is_active'),
        ]);

        // Cập nhật liên kết sản phẩm
        $promotion->products()->detach();
        if ($request->applies_to === 'specific_products' && $request->products) {
            $promotion->products()->attach($request->products);
        }

        // Cập nhật liên kết danh mục
        $promotion->categories()->detach();
        if ($request->applies_to === 'specific_categories' && $request->categories) {
            $promotion->categories()->attach($request->categories);
        }

        return redirect()->route('promotions.index')
                        ->with('success', 'Khuyến mại đã được cập nhật thành công!');
    }

    // Xóa khuyến mại
    public function destroy(Promotion $promotion)
    {
        // Kiểm tra nếu khuyến mại đã được sử dụng
        if ($promotion->used_count > 0) {
            return redirect()->route('promotions.index')
                            ->with('error', 'Không thể xóa khuyến mại đã được sử dụng!');
        }

        $promotion->products()->detach();
        $promotion->categories()->detach();
        $promotion->delete();

        return redirect()->route('promotions.index')
                        ->with('success', 'Khuyến mại đã được xóa thành công!');
    }

    // Bật/tắt khuyến mại
    public function toggleStatus(Promotion $promotion)
    {
        $promotion->update(['is_active' => !$promotion->is_active]);

        $status = $promotion->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        
        return redirect()->route('promotions.index')
                        ->with('success', "Khuyến mại đã được {$status} thành công!");
    }

    // API: Kiểm tra mã khuyến mại
    public function checkCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'order_value' => 'required|numeric|min:0',
            'products' => 'nullable|array',
        ]);

        $promotion = Promotion::findByCode($request->code);

        if (!$promotion) {
            return response()->json([
                'valid' => false,
                'message' => 'Mã khuyến mại không tồn tại'
            ]);
        }

        $canApply = $promotion->canApplyToOrder($request->order_value, $request->products ?? []);

        if (!$canApply) {
            $message = 'Mã khuyến mại không hợp lệ';
            
            if (!$promotion->isUsable()) {
                if (!$promotion->is_active) {
                    $message = 'Mã khuyến mại đã bị vô hiệu hóa';
                } elseif (Carbon::now() < $promotion->start_date) {
                    $message = 'Mã khuyến mại chưa có hiệu lực';
                } elseif (Carbon::now() > $promotion->end_date) {
                    $message = 'Mã khuyến mại đã hết hạn';
                } elseif ($promotion->usage_limit && $promotion->used_count >= $promotion->usage_limit) {
                    $message = 'Mã khuyến mại đã hết lượt sử dụng';
                }
            } elseif ($promotion->min_order_value && $request->order_value < $promotion->min_order_value) {
                $message = 'Đơn hàng chưa đạt giá trị tối thiểu: ' . number_format($promotion->min_order_value) . 'đ';
            }

            return response()->json([
                'valid' => false,
                'message' => $message
            ]);
        }

        $discountAmount = $promotion->calculateDiscount($request->order_value, $request->products ?? []);

        return response()->json([
            'valid' => true,
            'promotion' => [
                'id' => $promotion->id,
                'title' => $promotion->title,
                'code' => $promotion->code,
                'discount_type' => $promotion->discount_type,
                'discount_value' => $promotion->discount_value,
                'discount_amount' => $discountAmount,
            ],
            'message' => 'Mã khuyến mại hợp lệ!'
        ]);
    }

    // Lấy danh sách khuyến mại có thể sử dụng
    public function getUsablePromotions()
    {
        $promotions = Promotion::usable()
                              ->select('id', 'title', 'code', 'description', 'discount_type', 'discount_value', 'min_order_value')
                              ->get();

        return response()->json($promotions);
    }
}
