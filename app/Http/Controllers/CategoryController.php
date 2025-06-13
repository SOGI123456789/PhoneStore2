<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Components\Recusive;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $categories;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    public function create()
    {
        $data = $this->category->all(); // Đảm bảo gọi phương thức all() để lấy tất cả danh mục
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive();  // Phương thức đệ quy với parent_id = 0
        return view('categories.add', compact('htmlOption'));  // Trả lại view với dữ liệu đã được xử lý
    }
    public function index()
    {
            $categories = $this->category->latest()->paginate(5);
        return view('categories.index',compact('categories'));
    }
    public function store(Request $request)
    {
        $parent_id = $request->has('parent_id') ? (int)$request->parent_id : null;

        $this->category->create([
            'name' => $request->name,
            'parent_id' => $parent_id,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('categories.index');
    }
}
