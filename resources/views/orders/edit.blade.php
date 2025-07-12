@extends('layouts.admin')

@section('title', 'Sửa đơn hàng')

@section('content')
    <div class="content-wrapper">
        @include('partials.content-header',['name'=>'Orders','key'=>'Edit'])

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('orders.update', ['id' => $order->id]) }}" method="POST">
                            @csrf

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Thông tin đơn hàng #{{ $order->id }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Thông tin khách hàng</h5>
                                            <p><strong>Tên:</strong> {{ $order->customer_name }}</p>
                                            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                                            <p><strong>Số điện thoại:</strong> {{ $order->customer_phone ?: 'Không có' }}</p>
                                            <p><strong>Địa chỉ:</strong> {{ $order->customer_address ?: 'Không có' }}</p>
                                            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }}đ</p>
                                            <p><strong>Phương thức thanh toán:</strong> 
                                                @if($order->payment_method == 'cod') 
                                                    COD (Thanh toán khi nhận hàng)
                                                @elseif($order->payment_method == 'bank_transfer') 
                                                    Chuyển khoản ngân hàng
                                                @else 
                                                    {{ $order->payment_method }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Cập nhật trạng thái</h5>
                                            <div class="form-group">
                                                <label for="status">Tình trạng đơn hàng</label>
                                                <select class="form-control" name="status" required>
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao</option>
                                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="payment_status">Trạng thái thanh toán</label>
                                                <select class="form-control" name="payment_status" required>
                                                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Chưa thanh toán</option>
                                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Thanh toán thất bại</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
                                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
