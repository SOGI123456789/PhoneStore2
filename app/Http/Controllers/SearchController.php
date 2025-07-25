<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        $categoryId = $request->input('category_id');
        $sortBy = $request->input('sort_by', 'newest');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');

        // Nếu không có từ khóa tìm kiếm
        if (empty($query)) {
            return back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm!');
        }

        // Tìm kiếm sản phẩm
        $products = Product::where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('content', 'like', '%' . $query . '%');
            });

        // Lọc theo danh mục nếu có
        if (!empty($categoryId)) {
            $products->where('catalog_id', $categoryId);
        }
        // Lọc theo RAM
        $ramArr = $request->input('ram', []);
        if (!empty($ramArr)) {
            $products->whereHas('attributes', function($q) use ($ramArr) {
                $q->where('attribute_key', 'ram')->whereIn('attribute_value', $ramArr);
            });
        }
        // Lọc theo giá tiền
        if (!empty($priceMin)) {
            $products->where('price', '>=', $priceMin);
        }
        if (!empty($priceMax)) {
            $products->where('price', '<=', $priceMax);
        }

        // Sắp xếp kết quả
        switch ($sortBy) {
            case 'price_asc':
                $products = $products->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $products = $products->orderBy('price', 'desc');
                break;
            case 'name':
                $products = $products->orderBy('name', 'asc');
                break;
            case 'popular':
                $products = $products->orderBy('buyed', 'desc');
                break;
            default: // newest
                $products = $products->orderBy('created_at', 'desc');
        }

        // Lấy kết quả với phân trang
        $products = $products->paginate(12);
        
        // Lấy danh mục để hiển thị filter
        $categories = Category::where('parent_id', '!=', null)->get();

        return view('search-results', compact('products', 'query', 'categories', 'categoryId', 'sortBy', 'priceMin', 'priceMax'));
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Tìm kiếm sản phẩm theo tên
        $productSuggestions = Product::where('name', 'like', '%' . $query . '%')
            ->limit(6)
            ->pluck('name')
            ->unique()
            ->values();

        // Tìm kiếm theo danh mục
        $categorySuggestions = Category::where('name', 'like', '%' . $query . '%')
            ->where('parent_id', '!=', 0)
            ->limit(3)
            ->pluck('name')
            ->map(function($name) {
                return $name . ' (Danh mục)';
            });

        // Kết hợp và giới hạn kết quả
        $allSuggestions = $productSuggestions->concat($categorySuggestions)->take(8);

        return response()->json($allSuggestions->values());
    }
}
