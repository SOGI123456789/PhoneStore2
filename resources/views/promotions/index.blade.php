@extends('layouts.admin')   <!-- khi view home được load sẽ bắt đầu tìm layouts\admin để extend -->


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('partials.content-header',['name'=>'Promotions','key'=>'List'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <a href="{{ route('promotions.create') }}" class="btn-success btn-lg float-right m-2">Thêm</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Mã khuyến mại</th>
                                <th scope="col">Loại giảm giá</th>
                                <th scope="col">Giá trị</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Sử dụng</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($promotions as $key => $promotion)
                                <tr>
                                    <th scope="row">
                                        {{ ($promotions->currentPage() - 1) * $promotions->perPage() + $key + 1 }}
                                    </th>
                                    <td>{{ $promotion->title }}</td>
                                    <td>
                                        <code>{{ $promotion->code }}</code>
                                    </td>
                                    <td>
                                        @if($promotion->discount_type == 'percentage')
                                            <span class="badge badge-info">Phần trăm</span>
                                        @else
                                            <span class="badge badge-warning">Cố định</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($promotion->discount_type == 'percentage')
                                            {{ $promotion->discount_value }}%
                                        @else
                                            {{ number_format($promotion->discount_value) }}đ
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            {{ $promotion->start_date->format('d/m/Y') }} - 
                                            {{ $promotion->end_date->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($promotion->is_active)
                                            @if($promotion->isUsable())
                                                <span class="badge badge-success">Đang hoạt động</span>
                                            @else
                                                <span class="badge badge-warning">Không khả dụng</span>
                                            @endif
                                        @else
                                            <span class="badge badge-danger">Đã tắt</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $promotion->used_count }}
                                        @if($promotion->usage_limit)
                                            / {{ $promotion->usage_limit }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('promotions.edit', $promotion) }}" 
                                               class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('promotions.toggle', $promotion) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-{{ $promotion->is_active ? 'secondary' : 'success' }} btn-sm"
                                                        title="{{ $promotion->is_active ? 'Tắt' : 'Bật' }}">
                                                    <i class="fas fa-{{ $promotion->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            @if($promotion->used_count == 0)
                                            <form action="{{ route('promotions.destroy', $promotion) }}" 
                                                  method="POST" style="display: inline;"
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa khuyến mại này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Chưa có khuyến mại nào</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">{{ $promotions->links('pagination::bootstrap-4') }}</div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
