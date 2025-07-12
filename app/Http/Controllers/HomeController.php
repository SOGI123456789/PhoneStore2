<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user && $user->role_id==1) {
            // Trả về view home cho admin
            return view('home');
        } else {
            // Nếu không phải admin, chuyển về index
            return redirect()->route('index');
        }
    }

    public function showIndex()
    {
        // Lấy tất cả danh mục cha với sản phẩm (và thuộc tính) và danh mục con
        $parentCategories = Category::whereNull('parent_id')
            ->with(['products.attributes', 'children.products.attributes'])
            ->get();
        
        // Lấy tất cả danh mục con
        $childCategories = Category::whereNotNull('parent_id')->get();
        
        // Lấy sản phẩm mới nhất (10 sản phẩm)
        $newProducts = Product::with('attributes')->latest()->take(10)->get();
        
        // Lấy sản phẩm hot deals (tất cả sản phẩm vì chưa có discount_price)
        $hotDeals = Product::with('attributes')->take(6)->get();
        
        // Lấy sản phẩm bán chạy nhất
        $bestSellers = Product::with('attributes')->orderBy('buyed', 'desc')->take(8)->get();

        return view('index', compact('parentCategories', 'childCategories', 'newProducts', 'hotDeals', 'bestSellers'));
    }
}