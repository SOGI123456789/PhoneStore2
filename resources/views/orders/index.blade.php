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
                                    <th scope="col">ID Đơn hàng</th>
                                    <th scope="col">Tên người đặt</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Tình trạng</th>
                                    <th scope="col">Chi tiết</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                        <td>
                                            <span class="badge 
                                                @if($order->status == 'pending') badge-warning
                                                @elseif($order->status == 'processing') badge-info
                                                @elseif($order->status == 'shipped') badge-primary
                                                @elseif($order->status == 'delivered') badge-success
                                                @else badge-danger
                                                @endif
                                            ">
                                                @if($order->status == 'pending') Chờ xử lý
                                                @elseif($order->status == 'processing') Đang xử lý
                                                @elseif($order->status == 'shipped') Đã gửi hàng
                                                @elseif($order->status == 'delivered') Đã giao hàng
                                                @else Đã hủy
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm" onclick="toggleOrderDetails({{ $order->id }})">
                                                <i class="fas fa-eye"></i> Xem chi tiết
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Chi tiết đơn hàng (ẩn mặc định) -->
                                    <tr id="order-details-{{ $order->id }}" style="display: none;">
                                        <td colspan="5">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Chi tiết đơn hàng #{{ $order->id }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6><strong>Thông tin khách hàng:</strong></h6>
                                                            <p><strong>Tên:</strong> {{ $order->customer_name }}</p>
                                                            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                                                            <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                                                            <p><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6><strong>Thông tin đơn hàng:</strong></h6>
                                                            <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }}</p>
                                                            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }}đ</p>
                                                            <p><strong>Ghi chú:</strong> {{ $order->notes ?? 'Không có ghi chú' }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <h6><strong>Sản phẩm trong đơn hàng:</strong></h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sản phẩm</th>
                                                                    <th>Số lượng</th>
                                                                    <th>Giá</th>
                                                                    <th>Tổng</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if($order->orderItems)
                                                                    @foreach($order->orderItems as $item)
                                                                    <tr>
                                                                        <td>{{ $item->product_name }}</td>
                                                                        <td>{{ $item->quantity }}</td>
                                                                        <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                                                        <td>{{ number_format($item->total, 0, ',', '.') }}đ</td>
                                                                    </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Chưa có đơn hàng nào</td>
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

    <script>
    function toggleOrderDetails(orderId) {
        const detailsRow = document.getElementById('order-details-' + orderId);
        const button = event.target.closest('button');
        
        if (detailsRow.style.display === 'none') {
            detailsRow.style.display = 'table-row';
            button.innerHTML = '<i class="fas fa-eye-slash"></i> Ẩn chi tiết';
            button.classList.remove('btn-info');
            button.classList.add('btn-secondary');
        } else {
            detailsRow.style.display = 'none';
            button.innerHTML = '<i class="fas fa-eye"></i> Xem chi tiết';
            button.classList.remove('btn-secondary');
            button.classList.add('btn-info');
        }
    }
    </script>

