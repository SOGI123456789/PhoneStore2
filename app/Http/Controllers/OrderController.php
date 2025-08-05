<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Hiển thị chi tiết đơn hàng
    public function detail($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        return view('orders.detail', compact('order'));
    }
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
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cod,bank_transfer',
            'promotion_id' => 'nullable|integer|exists:promotions,id',
            'promotion_code' => 'nullable|string|max:50',
            'discount_amount' => 'nullable|numeric|min:0'
        ]);

        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return response()->json(['error' => 'Giỏ hàng của bạn đang trống!'], 400);
        }

        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Xử lý khuyến mại
        $promotionId = null;
        $promotionCode = null;
        $discountAmount = 0;
        
        if ($request->promotion_id && $request->promotion_code) {
            $promotion = \App\Models\Promotion::find($request->promotion_id);
            
            if ($promotion && $promotion->code === $request->promotion_code) {
                // Lấy danh sách product IDs trong giỏ hàng
                $productIds = array_keys($cart);
                
                // Kiểm tra khuyến mại có thể áp dụng không
                if ($promotion->canApplyToOrder($subtotal, $productIds)) {
                    $calculatedDiscount = $promotion->calculateDiscount($subtotal, $productIds);
                    
                    if ($calculatedDiscount > 0) {
                        $promotionId = $promotion->id;
                        $promotionCode = $promotion->code;
                        $discountAmount = $calculatedDiscount;
                        
                        // Tăng số lần sử dụng khuyến mại
                        $promotion->incrementUsage();
                    }
                }
            }
        }

        $finalTotal = $subtotal - $discountAmount;

        try {
            // Tạo đơn hàng với thông tin khách hàng và khuyến mại
            $order = Order::create([
                'user_id'         => Auth::check() ? Auth::id() : null,
                'customer_name'   => $request->customer_name,
                'customer_email'  => $request->customer_email,
                'customer_phone'  => $request->customer_phone,
                'customer_address'=> $request->customer_address,
                'total_amount'    => $finalTotal,
                'promotion_id'    => $promotionId,
                'promotion_code'  => $promotionCode,
                'discount_amount' => $discountAmount,
                'status'          => 'pending',
                'payment_method'  => $request->payment_method,
                'payment_status'  => 'pending',
                'notes'           => $request->notes
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

            // Lưu lịch sử sử dụng khuyến mại sau khi tạo đơn hàng thành công
            if ($promotionId) {
                \App\Models\PromotionUsage::create([
                    'promotion_id' => $promotionId,
                    'order_id' => $order->id,
                    'user_id' => Auth::check() ? Auth::id() : null,
                    'discount_amount' => $discountAmount,
                    'used_at' => now()
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
        $orders = Order::with(['orderItems.product'])->orderBy('id', 'asc')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('orders.detail', compact('order'));
    
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

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công!'
        ]);
    }

    // Cập nhật trạng thái thanh toán
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['payment_status' => $request->payment_status]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thanh toán thành công!'
        ]);
    }

    // Admin - Xóa đơn hàng
    public function adminDestroy($id)
    {
        $order = Order::findOrFail($id);
        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công!');
    }

    // Xóa đơn hàng (cho admin)
    public function delete($id)
    {
        try {
            $order = Order::findOrFail($id);
            
            // Xóa các order items trước
            $order->orderItems()->delete();
            
            // Xóa đơn hàng
            $order->delete();

            return redirect()->route('orders.index')->with('success', 'Xóa đơn hàng thành công!');
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', 'Có lỗi xảy ra khi xóa đơn hàng!');
        }
    }

    // Lấy thông tin đơn hàng để edit
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    // Cập nhật đơn hàng
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
            'imeis' => 'required|array',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status
        ]);

        // Cập nhật IMEI cho từng sản phẩm
        foreach ($request->imeis as $itemId => $imei) {
            $orderItem = $order->orderItems()->where('id', $itemId)->first();
            if ($orderItem) {
                $orderItem->imei = $imei;
                $orderItem->save();
            }
        }

        return redirect()->route('orders.index')->with('success', 'Cập nhật đơn hàng thành công!');
    }

    // Hủy đơn hàng
    public function cancelOrder($id)
    {
        $order = Auth::user()->orders()->where('id', $id)->firstOrFail();

        // Chỉ cho phép hủy nếu đơn chưa giao hoặc chưa bị hủy
        if (in_array($order->status, ['pending', 'processing'])) {
            $order->status = 'cancelled';
            $order->save();
            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công!');
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng này!');
    }
}
