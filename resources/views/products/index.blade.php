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
                                <th scope="col">Mô tả</th>
                                <th scope="col">Giá</th>
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
                                        <td>{{ $product->content }}</td>
                                        <td>{{ number_format($product->price) }} đ</td>
                                        <td>
                                            @if($product->image_link)
                                                <img src="{{ asset('storage/' . $product->image_link) }}" alt="Ảnh" width="60">
                                            @else
                                                Không có ảnh
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="btn btn-default">Sửa</a>
                                            <form action="{{ route('products.delete', ['product' => $product->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                            </form>
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