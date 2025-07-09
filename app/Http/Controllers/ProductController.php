<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10); // Sử dụng paginate thay vì all()
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.add');
    }

    public function store(Request $request)
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
        ]);
        $data = $request->all();
        if ($request->hasFile('image_link')) {
            $file = $request->file('image_link');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/products', $fileName); // Đúng chuẩn
            $data['image_link'] = 'products/' . $fileName; // Không có public/ ở đầu
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
}