<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Hiển thị form checkout
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

    // Xử lý gửi đơn hàng
    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shopping-cart')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        if (Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đặt hàng!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'Chờ xử lý',
        ]);

        // Lưu từng sản phẩm vào order_items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Xóa giỏ hàng
        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công!');
    }

    // Tạo đơn hàng qua AJAX
    public function createOrder(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Bạn cần đăng nhập để đặt hàng'], 401);
        }

        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return response()->json(['error' => 'Giỏ hàng của bạn đang trống!'], 400);
        }

        $user = Auth::user();

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        try {
            // Tạo đơn hàng với thông tin khách hàng từ user
            $order = Order::create([
                'user_id'         => $user->id,
                'customer_name'   => $user->name,
                'customer_email'  => $user->email,
                'customer_phone'  => $user->phone ?? '',
                'customer_address'=> $user->address ?? '',
                'total_amount'    => $total,
                'status'          => 'pending',
                'payment_method'  => 'cod',
                'notes'           => ''
            ]);

            foreach($cart as $id => $item) {
                OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $id,
                    'product_name'=> $item['name'],
                    'price'       => $item['price'],
                    'quantity'    => $item['quantity'],
                    'total'       => $item['price'] * $item['quantity']
                ]);
            }

            session()->forget('cart');

            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được tạo thành công!',
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    // Hiển thị danh sách đơn hàng cho admin
    public function index()
    {
        $orders = Order::with('items')->orderBy('created_at', 'desc')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('orders.index', compact('order'));
    
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Tạo đơn hàng
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'total_amount' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'notes' => $request->notes
        ]);

        // Tạo chi tiết đơn hàng
        foreach($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_name' => $item['name'],
                'product_price' => $item['price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity']
            ]);
        }

        // Xóa giỏ hàng
        session()->forget('cart');

        return redirect()->route('order.success', $order->id)->with('success', 'Đặt hàng thành công!');
    }

    // Trang thành công
    public function orderSuccess($orderId)
    {
        $order = Order::with('orderItems')->findOrFail($orderId);
        return view('order-success', compact('order'));
    }

    // Admin - Danh sách đơn hàng
    public function adminIndex()
    {
        $orders = Order::with('orderItems')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    // Admin - Chi tiết đơn hàng
    public function adminShow($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Admin - Cập nhật trạng thái đơn hàng
    public function adminUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,shipping,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $id)->with('success', 'Cập nhật trạng thái thành công!');
    }

    // Admin - Xóa đơn hàng
    public function adminDestroy($id)
    {
        $order = Order::findOrFail($id);
        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công!');
    }
}
