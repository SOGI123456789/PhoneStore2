<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('shopping-cart', compact('cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        
        $product = Product::findOrFail($productId);
        
        $cart = session()->get('cart', []);
        
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->discount_price ?: $product->price,
                'image' => $product->image_link,
                'quantity' => $quantity
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
            'cart_count' => count($cart)
        ]);
    }

    public function updateCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        $cart = session()->get('cart', []);
        
        if(isset($cart[$productId])) {
            if($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]);
            }
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Giỏ hàng đã được cập nhật!'
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $productId = $request->product_id;
        
        $cart = session()->get('cart', []);
        
        if(isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng!',
            'cart_count' => count($cart)
        ]);
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        return response()->json(['count' => count($cart)]);
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('shopping-cart')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('checkout', compact('cart', 'total'));
    }
}
