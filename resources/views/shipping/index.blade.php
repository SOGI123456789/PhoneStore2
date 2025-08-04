@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        @include('partials.content-header', ['name'=>'Shipping','key'=>'List'])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">ID Đơn hàng</th>
                                    <th scope="col">Tên người đặt</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Số điện thoại</th>
                                    <th scope="col">Địa chỉ</th>
                                    <th scope="col">Chi tiết đơn hàng</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <span class="badge badge-primary" style="font-size: 14px;">#{{ $order->id }}</span>
                                        </td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->customer_email }}</td>
                                        <td>{{ $order->customer_phone ?: 'Không có' }}</td>
                                        <td>{{ \Str::limit($order->customer_address, 30) ?: 'Không có' }}</td>
                                        <td style="max-width: 200px;">
                                            @if($order->items && $order->items->count() > 0)
                                                <div style="max-height: 100px; overflow-y: auto;">
                                                    @foreach($order->items as $item)
                                                        <div class="mb-1 p-1" style="font-size: 12px; border-bottom: 1px solid #eee;">
                                                            <strong>{{ \Str::limit($item->product->name ?? 'Sản phẩm đã xóa', 25) }}</strong><br>
                                                            <small class="text-muted">
                                                                SL: {{ $item->quantity }} × {{ number_format($item->price, 0, ',', '.') }}đ
                                                                = {{ number_format($item->quantity * $item->price, 0, ',', '.') }}đ
                                                            </small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <small class="text-info">
                                                    <strong>Tổng: {{ $order->items->count() }} sản phẩm</strong>
                                                </small>
                                            @else
                                                <span class="text-muted">Chưa có sản phẩm</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                        <td>
                                            <a href="{{ route('shipping.show', $order->id) }}" class="btn btn-info btn-sm">Chi tiết</a>
                                            <form action="{{ route('shipping.accept', $order->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @if($order->shipper_id === Auth::id() && $order->status === 'shipping')
                                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Xác nhận hoàn thành đơn hàng này?')">Hoàn thành đơn hàng</button>
                                                @elseif($order->shipper_id === null && $order->status === 'processing')
                                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn chắc chắn nhận giao đơn hàng này?')">Nhận giao</button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Không có đơn hàng nào cần giao!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
