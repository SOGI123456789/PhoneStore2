<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    // Hiển thị tất cả đánh giá của sản phẩm
    public function index(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        // Khởi tạo query
        $query = ProductReview::where('product_id', $productId);
        
        // Lọc theo rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        // Lọc theo loại
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'verified':
                    $query->where('is_verified', true);
                    break;
                case 'with_review':
                    $query->whereNotNull('review');
                    break;
            }
        }
        
        // Sắp xếp
        $sortBy = $request->get('sort_by', 'newest');
        
        switch ($sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'highest_rating':
                $query->orderBy('rating', 'desc')->latest();
                break;
            case 'lowest_rating':
                $query->orderBy('rating', 'asc')->latest();
                break;
            default: // newest
                $query->latest();
                break;
        }
        
        // Phân trang
        $reviews = $query->with('user')->paginate(10);
        
        return view('reviews.index', compact('product', 'reviews', 'sortBy'));
    }
    // Hiển thị form đánh giá sản phẩm
    public function create(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đánh giá sản phẩm');
        }

        // Kiểm tra đã đánh giá chưa
        $existingReview = ProductReview::where('product_id', $productId)
            ->where('user_id', $user->id)
            ->first();

        if ($existingReview) {
            return redirect()->route('product.detail', $productId)
                ->with('error', 'Bạn đã đánh giá sản phẩm này rồi');
        }

        // Kiểm tra đã mua sản phẩm chưa
        $hasPurchased = OrderItem::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->where('status', 'completed');
            })
            ->where('product_id', $productId)
            ->exists();

        return view('reviews.create', compact('product', 'hasPurchased'));
    }

    // Lưu đánh giá
    public function store(Request $request, $productId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
            'pros' => 'nullable|array',
            'pros.*' => 'string|max:100',
            'cons' => 'nullable|array', 
            'cons.*' => 'string|max:100',
            'reviewer_name' => 'nullable|string|max:50'
        ]);

        $product = Product::findOrFail($productId);

        // Kiểm tra đã đánh giá chưa
        $existingReview = ProductReview::where('product_id', $productId)
            ->where('user_id', $user->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi');
        }

        // Kiểm tra đã mua sản phẩm chưa
        $orderItem = OrderItem::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->where('status', 'completed');
            })
            ->where('product_id', $productId)
            ->first();

        DB::transaction(function() use ($request, $productId, $user, $orderItem) {
            // Tạo review
            ProductReview::create([
                'product_id' => $productId,
                'user_id' => $user->id,
                'order_id' => $orderItem ? $orderItem->order_id : null,
                'rating' => $request->rating,
                'review' => $request->review,
                'is_verified' => $orderItem ? true : false,
                'pros' => $request->pros ? array_filter($request->pros) : null,
                'cons' => $request->cons ? array_filter($request->cons) : null,
                'reviewer_name' => $request->reviewer_name ?: null,
            ]);

            // Cập nhật rating cho product
            $this->updateProductRating($productId);
        });

        return redirect()->route('product.detail', $productId)
            ->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }

    // Hiển thị form chỉnh sửa đánh giá
    public function edit($reviewId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $review = ProductReview::where('id', $reviewId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if (!$review->canEdit($user->id)) {
            return back()->with('error', 'Bạn chỉ có thể chỉnh sửa đánh giá trong vòng 24 giờ');
        }

        return view('reviews.edit', compact('review'));
    }

    // Cập nhật đánh giá
    public function update(Request $request, $reviewId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
            'pros' => 'nullable|array',
            'pros.*' => 'string|max:100',
            'cons' => 'nullable|array',
            'cons.*' => 'string|max:100',
        ]);

        $review = ProductReview::where('id', $reviewId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if (!$review->canEdit($user->id)) {
            return back()->with('error', 'Bạn chỉ có thể chỉnh sửa đánh giá trong vòng 24 giờ');
        }

        DB::transaction(function() use ($request, $review) {
            $review->update([
                'rating' => $request->rating,
                'review' => $request->review,
                'pros' => $request->pros ? array_filter($request->pros) : null,
                'cons' => $request->cons ? array_filter($request->cons) : null,
            ]);

            // Cập nhật lại rating cho product
            $this->updateProductRating($review->product_id);
        });

        return redirect()->route('product.detail', $review->product_id)
            ->with('success', 'Đánh giá đã được cập nhật!');
    }

    // Xóa đánh giá
    public function destroy($reviewId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $review = ProductReview::where('id', $reviewId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $productId = $review->product_id;

        DB::transaction(function() use ($review, $productId) {
            $review->delete();
            $this->updateProductRating($productId);
        });

        return redirect()->route('product.detail', $productId)
            ->with('success', 'Đánh giá đã được xóa');
    }

    // Hiển thị tất cả đánh giá của sản phẩm
    public function index($productId, Request $request)
    {
        $product = Product::findOrFail($productId);
        
        $query = ProductReview::where('product_id', $productId)
            ->where('is_approved', true)
            ->with('user');

        // Lọc theo rating
        if ($request->rating) {
            $query->where('rating', $request->rating);
        }

        // Lọc theo loại đánh giá
        if ($request->filter == 'verified') {
            $query->where('is_verified', true);
        } elseif ($request->filter == 'with_review') {
            $query->whereNotNull('review');
        }

        // Sắp xếp
        $sortBy = $request->sort_by ?? 'newest';
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'highest_rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'lowest_rating':
                $query->orderBy('rating', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
        }

        $reviews = $query->paginate(10);

        return view('reviews.index', compact('product', 'reviews', 'sortBy'));
    }

    // Cập nhật rating trung bình cho product
    private function updateProductRating($productId)
    {
        $reviews = ProductReview::where('product_id', $productId)
            ->where('is_approved', true);

        $rateCount = $reviews->count();
        $rateTotal = $reviews->sum('rating');

        Product::where('id', $productId)->update([
            'rate_count' => $rateCount,
            'rate_total' => $rateTotal,
        ]);
    }

    // AJAX: Đánh dấu review hữu ích
    public function helpful(Request $request, $reviewId)
    {
        // TODO: Implement helpful feature nếu cần
        return response()->json(['success' => true]);
    }
}
