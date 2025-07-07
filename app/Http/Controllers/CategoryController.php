<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Components\Recusive;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $categories;
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    public function create()
    {
        $htmlOption = $this->getCategory();
        return view('categories.add', compact('htmlOption'));  // Trả lại view với dữ liệu đã được xử lý
    }
    public function index()
    {
            $categories = $this->category->orderBy('id', 'asc')->paginate(perPage: 10);
        return view('categories.index',compact('categories'));
    }
    public function store(Request $request)
    {
        $parent_id = $request->has('parent_id') ? (int)$request->parent_id : null;

        // Kiểm tra trùng tên danh mục
        if ($this->category->where('name', $request->name)->exists()) {
            return redirect()->back()
                ->withErrors(['name' => 'Tên danh mục đã tồn tại!'])
                ->withInput();
        }

        $this->category->create([
            'name' => $request->name,
            'parent_id' => $parent_id,
        ]);
        return redirect()->route('categories.index');
    }
    public function getCategory($selectedParentId = 0)
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        return $recusive->categoryRecusive(0, $selectedParentId);
    }
    public function edit($id)
    {
        $category = $this->category->findOrFail($id);
        $htmlOption = $this->getCategory($category->parent_id); // Truyền đúng selected id
        return view('categories.edit', compact('category', 'htmlOption'));
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|integer'
        ]);

        $category = $this->category->findOrFail($id);
        $category->update([
            'name' => $request->name,
            'parent_id' => (int) $request->parent_id,
   
        ]);

        return redirect()->route('categories.index')->with('success', 'Cập nhật thành công!');
    }
    public function delete($id)
    {
        $category = $this->category->findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Xóa thành công!');
    }
}
