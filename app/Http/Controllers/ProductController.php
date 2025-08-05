<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['variants', 'category'])->paginate(10);
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
            'name' => 'required|string|max:255',
            'catalog_id' => 'required|integer|exists:categories,id',
            'content' => 'nullable|string',
            'image_link' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'brand' => 'nullable|string|max:100',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_link')) {
            $file = $request->file('image_link');
            $path = $file->store('products', 'public');
            $data['image_link'] = $path;
        }

        $product = Product::create($data);

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công! Hãy thêm variants cho sản phẩm.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('parent_id', '!=', 0)->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'catalog_id' => 'required|integer|exists:categories,id',
            'content' => 'nullable|string',
            'image_link' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'brand' => 'nullable|string|max:100',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_link')) {
            // Xóa ảnh cũ nếu có
            if ($product->image_link && Storage::disk('public')->exists($product->image_link)) {
                Storage::disk('public')->delete($product->image_link);
            }
            
            $file = $request->file('image_link');
            $path = $file->store('products', 'public');
            $data['image_link'] = $path;
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function delete(Product $product)
    {
        // Xóa ảnh sản phẩm nếu có
        if ($product->image_link && Storage::disk('public')->exists($product->image_link)) {
            Storage::disk('public')->delete($product->image_link);
        }

        // Xóa tất cả variants của sản phẩm
        foreach ($product->variants as $variant) {
            if ($variant->image_link && Storage::disk('public')->exists($variant->image_link)) {
                Storage::disk('public')->delete($variant->image_link);
            }
        }
        $product->variants()->delete();

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    public function detail($id)
    {
        $product = Product::with(['attributes', 'variants'])->findOrFail($id);
        return view('detail', compact('product'));
    }

    // Quản lý variants
    public function variants($productId)
    {
        $product = Product::with('variants')->findOrFail($productId);
        return view('products.variants.index', compact('product'));
    }

    public function createVariant($productId)
    {
        $product = Product::findOrFail($productId);
        return view('products.variants.create', compact('product'));
    }

    public function storeVariant(Request $request, $productId)
    {
        $request->validate([
            'color' => 'required|string|max:50',
            'ram' => 'required|string|max:20',
            'rom' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'quantity' => 'required|integer|min:0',
            'image_link' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();
        $data['product_id'] = $productId;

        if ($request->hasFile('image_link')) {
            $file = $request->file('image_link');
            $path = $file->store('variants', 'public');
            $data['image_link'] = $path;
        }

        ProductVariant::create($data);

        return redirect()->route('products.variants', $productId)
                        ->with('success', 'Thêm variant thành công!');
    }

    public function editVariant($productId, $variantId)
    {
        $product = Product::findOrFail($productId);
        $variant = ProductVariant::where('product_id', $productId)->findOrFail($variantId);
        return view('products.variants.edit', compact('product', 'variant'));
    }

    public function updateVariant(Request $request, $productId, $variantId)
    {
        $request->validate([
            'color' => 'required|string|max:50',
            'ram' => 'required|string|max:20',
            'rom' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'quantity' => 'required|integer|min:0',
            'image_link' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $variant = ProductVariant::where('product_id', $productId)->findOrFail($variantId);
        $data = $request->all();

        if ($request->hasFile('image_link')) {
            // Xóa ảnh cũ nếu có
            if ($variant->image_link && Storage::disk('public')->exists($variant->image_link)) {
                Storage::disk('public')->delete($variant->image_link);
            }
            
            $file = $request->file('image_link');
            $path = $file->store('variants', 'public');
            $data['image_link'] = $path;
        }

        $variant->update($data);

        return redirect()->route('products.variants', $productId)
                        ->with('success', 'Cập nhật variant thành công!');
    }

    public function deleteVariant($productId, $variantId)
    {
        $variant = ProductVariant::where('product_id', $productId)->findOrFail($variantId);
        
        // Xóa ảnh nếu có
        if ($variant->image_link && Storage::disk('public')->exists($variant->image_link)) {
            Storage::disk('public')->delete($variant->image_link);
        }

        $variant->delete();

        return redirect()->route('products.variants', $productId)
                        ->with('success', 'Xóa variant thành công!');
    }
}