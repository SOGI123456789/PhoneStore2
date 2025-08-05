@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="content-wrapper">
    @include('partials.content-header',['name'=>'Orders','key'=>'Detail'])
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h4>Chi tiết đơn hàng #{{ $order->id }}</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr><th width="30%">Tên người đặt</th><td>{{ $order->customer_name }}</td></tr>
                                <tr><th>Email</th><td>{{ $order->customer_email }}</td></tr>
                                <tr><th>Số điện thoại</th><td>{{ $order->customer_phone ?: 'Không có' }}</td></tr>
                                <tr><th>Địa chỉ</th><td>{{ $order->customer_address ?: 'Không có' }}</td></tr>
                                <tr><th>Ghi chú</th><td>{{ $order->notes ?: 'Không có' }}</td></tr>
                                <tr><th>Tổng tiền</th><td><strong>{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong></td></tr>
                                <tr>
                                    <th>Phương thức thanh toán</th>
                                    <td>
                                        @if($order->payment_method == 'cod') 
                                            COD (Thanh toán khi nhận hàng)
                                        @elseif($order->payment_method == 'bank_transfer') 
                                            Chuyển khoản ngân hàng
                                        @else 
                                            {{ $order->payment_method }}
                                        @endif
                                        <br>
                                        <span class="badge 
                                            @if($order->payment_status == 'pending') badge-warning
                                            @elseif($order->payment_status == 'paid') badge-success
                                            @else badge-danger
                                            @endif
                                        ">
                                            @if($order->payment_status == 'pending') Chưa thanh toán
                                            @elseif($order->payment_status == 'paid') Đã thanh toán
                                            @else Thanh toán thất bại
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Trạng thái đơn hàng</th>
                                    <td>
                                        <span class="badge
                                            @if($order->status == 'pending') badge-secondary
                                            @elseif($order->status == 'processing') badge-info
                                            @elseif($order->status == 'shipped') badge-primary
                                            @elseif($order->status == 'delivered') badge-success
                                            @elseif($order->status == 'cancelled') badge-danger
                                            @else badge-light
                                            @endif
                                        ">
                                            @if($order->status == 'pending') Chờ xử lý
                                            @elseif($order->status == 'processing') Đang xử lý
                                            @elseif($order->status == 'shipped') Đang giao
                                            @elseif($order->status == 'delivered') Đã giao
                                            @elseif($order->status == 'cancelled') Đã hủy
                                            @else {{ ucfirst($order->status) }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr><th>Ngày đặt</th><td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td></tr>
                            </table>
                            
                            <h5 class="mt-4">Chi tiết sản phẩm</h5>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th>Thành tiền</th>
                                        <th>IMEI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product_name ?? ($item->product->name ?? 'Sản phẩm đã xóa') }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                            <td><strong>{{ number_format($item->quantity * $item->price, 0, ',', '.') }}đ</strong></td>
                                            <td>{{ $item->imei ?: 'Không có' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Chưa có sản phẩm</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                            <div class="text-right mt-3">
                                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
