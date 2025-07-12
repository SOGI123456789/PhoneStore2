<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10); // Sử dụng paginate thay vì all()
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('parent_id', '!=', 0)->get();
        return view('products.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'catalog_id' => 'required|integer',
            'content' => 'nullable|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'image_link' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Sửa dòng này
            'viewer' => 'nullable|integer',
            'buyed' => 'nullable|integer',
            'rate_total' => 'nullable|integer',
            'rate_count' => 'nullable|integer',
            'quantity' => 'required|integer|min:0',
        ]);
        $data = $request->all();

            if ($request->hasFile('image_link')) {
                $file = $request->file('image_link');
                // Lưu file vào storage/app/public
                $path = $file->store('products', 'public');
                $data['image_link'] = $path;
            }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'catalog_id' => 'nullable|integer',
            'content' => 'nullable|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'image_link' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Sửa dòng này
            'viewer' => 'nullable|integer',
            'buyed' => 'nullable|integer',
            'rate_total' => 'nullable|integer',
            'rate_count' => 'nullable|integer',
            'quantity' => 'required|integer|min:0',
        ]);
        $data = $request->all();
        if ($request->hasFile('image_link')) {
            $file = $request->file('image_link');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/products', $fileName); // Đúng chuẩn
            $data['image_link'] = 'products/' . $fileName; // Không có public/ ở đầu
        }
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function delete(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
    public function detail($id)
    {
        $product = Product::with('attributes')->findOrFail($id);
        return view('detail', compact('product'));
    }
}