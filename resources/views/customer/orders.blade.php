<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đơn hàng của tôi - PhoneStore</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
</head>
<body class="cnt-home">
@include('partials.headerKH')

<div class="body-content outer-top-xs">
    <div class="container">
        <h2 class="text-center" style="margin-bottom:30px;">Đơn hàng của tôi</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($orders->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thanh toán</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                        <td>
                            @if($order->status == 'pending') Chờ xử lý
                            @elseif($order->status == 'processing') Đang xử lý
                            @elseif($order->status == 'shipped') Đang giao
                            @elseif($order->status == 'delivered') Đã giao
                            @elseif($order->status == 'cancelled') Đã hủy
                            @endif
                        </td>
                        <td>
                            @if($order->payment_status == 'pending') Chưa thanh toán
                            @elseif($order->payment_status == 'paid') Đã thanh toán
                            @else Thanh toán thất bại
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="collapse" data-target="#order-{{ $order->id }}">Xem</button>
                            @if(in_array($order->status, ['pending', 'processing']))
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Hủy đơn</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    <tr id="order-{{ $order->id }}" class="collapse">
                        <td colspan="6">
                            <strong>Danh sách sản phẩm:</strong>
                            <ul>
                                @foreach($order->orderItems as $item)
                                    <li>
                                        {{ $item->product_name ?? 'Sản phẩm đã xóa' }} - SL: {{ $item->quantity }} × {{ number_format($item->price, 0, ',', '.') }}đ
                                    </li>
                                @endforeach
                            </ul>
                            <strong>Ghi chú:</strong> {{ $order->notes ?? 'Không có' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="alert alert-info text-center">Bạn chưa có đơn hàng nào.</div>
        @endif
    </div>
</div>

@include('partials.footerKH')
<script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>
</html>