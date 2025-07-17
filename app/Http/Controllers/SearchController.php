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

        // Nếu không có từ khóa tìm kiếm
        if (empty($query)) {
            return back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm!');
        }

        // Tìm kiếm sản phẩm
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('content', 'like', '%' . $query . '%');

        // Lọc theo danh mục nếu có
        if (!empty($categoryId)) {
            $products = $products->where('catalog_id', $categoryId);
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

        return view('search-results', compact('products', 'query', 'categories', 'categoryId', 'sortBy'));
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = Product::where('name', 'like', '%' . $query . '%')
            ->limit(8)
            ->pluck('name')
            ->unique()
            ->values();

        return response()->json($suggestions);
    }
}
