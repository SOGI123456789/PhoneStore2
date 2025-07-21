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
    public function index(Request $request, $productId = null)
    {
        if ($productId) {
            $product = Product::findOrFail($productId);
            
            // Khởi tạo query
            $query = ProductReview::where('product_id', $productId)
                ->with('user');
            
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
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'highest_rating':
                    $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
                    break;
                case 'lowest_rating':
                    $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
                    break;
                default: // newest
                    $query->orderBy('created_at', 'desc');
                    break;
            }
            
            // Phân trang
            $reviews = $query->paginate(10);
            
            return view('reviews.index', compact('product', 'reviews', 'sortBy'));
        } else {
            $query = Product::query();

            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // Các điều kiện lọc khác...
            $products = $query->get();

            // Truyền $products về view
            return view('reviews.index', compact('products'));
        }
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
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
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
            // Upload images if any
            $imagePaths = null;
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('reviews', $filename, 'public');
                    $imagePaths[] = $path;
                }
            }

            // Tạo review
            ProductReview::create([
                'product_id' => $productId,
                'user_id' => $user->id,
                'order_id' => $orderItem ? $orderItem->order_id : null,
                'rating' => $request->rating,
                'review' => $request->review,
                'is_verified' => $orderItem ? true : false,
                'images' => $imagePaths,
                'reviewer_name' => $user->name,
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
            ->with('product')
            ->firstOrFail();

        if (!$review->canEdit($user->id)) {
            return back()->with('error', 'Bạn chỉ có thể chỉnh sửa đánh giá trong vòng 24 giờ');
        }

        $product = $review->product;

        return view('reviews.edit', compact('review', 'product'));
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
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'string',
            'new_images' => 'nullable|array|max:5',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        $review = ProductReview::where('id', $reviewId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if (!$review->canEdit($user->id)) {
            return back()->with('error', 'Bạn chỉ có thể chỉnh sửa đánh giá trong vòng 24 giờ');
        }

        DB::transaction(function() use ($request, $review) {
            // Xử lý hình ảnh
            $existingImages = $request->existing_images ?? [];
            $newImages = [];

            // Upload new images
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('reviews', $filename, 'public');
                    $newImages[] = $path;
                }
            }

            // Combine existing and new images
            $allImages = array_merge($existingImages, $newImages);
            
            // Limit to 5 images total
            $allImages = array_slice($allImages, 0, 5);

            $review->update([
                'rating' => $request->rating,
                'review' => $request->review,
                'images' => !empty($allImages) ? $allImages : null,
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



    // Cập nhật rating trung bình cho product
    private function updateProductRating($productId)
    {
        $reviews = ProductReview::where('product_id', $productId);

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
