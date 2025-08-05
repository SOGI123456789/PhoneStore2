@extends('layouts.admin')   <!-- khi view home được load sẽ bắt đầu tìm layouts\admin để extend -->

@section('title', )

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('partials.content-header',['name'=>'Products','key'=>'List'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('products.create') }}" class="btn-success btn-lg float-right m-2">Thêm</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Số variants</th>
                                <th scope="col">Khoảng giá</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key => $product)
                                    <tr>
                                        <th scope="row">
                                            {{ ($products->currentPage() - 1) * $products->perPage() + $key + 1 }}
                                        </th>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? 'Chưa phân loại' }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $product->variants->count() }} variants</span>
                                        </td>
                                        <td>
                                            @if($product->variants->isNotEmpty())
                                                @php
                                                    $minPrice = $product->variants->min('price');
                                                    $maxPrice = $product->variants->max('price');
                                                @endphp
                                                @if($minPrice == $maxPrice)
                                                    {{ number_format($minPrice) }} đ
                                                @else
                                                    {{ number_format($minPrice) }} - {{ number_format($maxPrice) }} đ
                                                @endif
                                            @else
                                                <span class="text-muted">Chưa có variant</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->image_link)
                                                <img src="{{ asset('storage/' . $product->image_link) }}" alt="Ảnh" width="60">
                                            @else
                                                Không có ảnh
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('products.variants', $product->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-list"></i> Variants
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <form action="{{ route('products.delete', $product->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này và tất cả variants?')">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">{{ $products->links('pagination::bootstrap-4') }}</div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection