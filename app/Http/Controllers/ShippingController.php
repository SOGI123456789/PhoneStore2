<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    // Hiển thị danh sách đơn hàng chưa giao
    public function index()
    {
        $orders = Order::where(function($query) {
            $query->whereNull('shipper_id')
                ->where('status', 'processing')
                ->where(function($q) {
                    $q->where('payment_method', 'cod')
                      ->orWhere('payment_status', 'paid');
                });
        })
        ->orWhere(function($q) {
            $q->where('shipper_id', Auth::id())
              ->where('status', 'shipping');
        })
        ->get();
        return view('shipping.index', compact('orders'));
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('shipping.show', compact('order'));
    }

    // Nhận giao đơn hàng
    public function accept($id)
    {
        $order = Order::findOrFail($id);
        if (
            $order->shipper_id === null &&
            $order->status === 'processing' &&
            (
                $order->payment_method === 'cod' || $order->payment_status === 'paid'
            )
        ) {
            $order->shipper_id = Auth::id();
            $order->status = 'shipping';
            $order->save(); 
            return redirect()->route('shipping.index')->with('success', 'Bạn đã nhận giao đơn hàng!');
        } elseif ($order->shipper_id == Auth::id() && $order->status === 'shipping') {
            $order->status = 'delivered';
            $order->save();
            return redirect()->route('shipping.index')->with('success', 'Bạn đã hoàn thành đơn hàng!');
        }
        return redirect()->route('shipping.index')->with('error', 'Không thể thao tác với đơn hàng này!');
    }
}
