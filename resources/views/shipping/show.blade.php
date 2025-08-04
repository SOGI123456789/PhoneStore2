@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        @include('partials.content-header',['name'=>'Shipping','key'=>'Detail'])
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
                                    <tr><th>Tổng tiền</th><td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td></tr>
                                    <tr><th>Phương thức thanh toán</th><td>{{ $order->payment_method }}</td></tr>
                                    <tr><th>Trạng thái</th><td>{{ $order->status }}</td></tr>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($order->items as $item)
                                            <tr>
                                                <td>{{ $item->product_name ?? ($item->product->name ?? 'Sản phẩm đã xóa') }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                                <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }}đ</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Chưa có sản phẩm</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <form action="{{ route('shipping.accept', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Bạn chắc chắn nhận giao đơn hàng này?')">Nhận giao đơn hàng này</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
