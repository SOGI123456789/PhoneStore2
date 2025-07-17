@extends('layouts.admin')

    @section('title', )

    @section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @include('partials.content-header',['name'=>'Orders','key'=>'List'])
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
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
                                    <th scope="col">Thanh toán</th>
                                    <th scope="col">Tình trạng</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $key => $order)
                                    <tr>
                                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $key + 1 }}</td>
                                        <td>
                                            <span class="badge badge-primary" style="font-size: 14px;">
                                                #{{ $order->id }}
                                            </span>
                                        </td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->customer_email }}</td>
                                        <td>{{ $order->customer_phone ?: 'Không có' }}</td>
                                        <td>{{ \Str::limit($order->customer_address, 30) ?: 'Không có' }}</td>
                                        <td style="max-width: 200px;">
                                            @if($order->orderItems && $order->orderItems->count() > 0)
                                                <div style="max-height: 100px; overflow-y: auto;">
                                                    @foreach($order->orderItems as $item)
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
                                                    <strong>Tổng: {{ $order->orderItems->count() }} sản phẩm</strong>
                                                </small>
                                            @else
                                                <span class="text-muted">Chưa có sản phẩm</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                        <td>
                                            <span class="badge 
                                                @if($order->payment_method == 'cod') badge-info
                                                @else badge-warning
                                                @endif
                                            ">
                                                @if($order->payment_method == 'cod') 
                                                    COD
                                                @elseif($order->payment_method == 'bank_transfer') 
                                                    Chuyển khoản
                                                @else 
                                                    {{ $order->payment_method }}
                                                @endif
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                @if($order->payment_status == 'pending') Chưa thanh toán
                                                @elseif($order->payment_status == 'paid') Đã thanh toán
                                                @else Thanh toán thất bại
                                                @endif
                                            </small>
                                        </td>
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
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>
                                              <a href="{{ route('orders.edit', ['id' => $order->id]) }}" class="btn btn-default btn-sm">Sửa</a>
                                            <form action="{{ route('admin.orders.delete', ['id' => $order->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">Chưa có đơn hàng nào</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-md-12">
                            @if($orders->hasPages())
                                {{ $orders->links('pagination::bootstrap-4') }}
                            @endif
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

    @endsection

