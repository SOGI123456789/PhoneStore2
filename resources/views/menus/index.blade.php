@extends('layouts.admin')   <!-- khi view home được load sẽ bắt đầu tìm layouts\admin để extend -->

@section('title', )

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('partials.content-header',['name'=>'menus','key'=>'List'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('menus.create') }}" class="btn-success btn-lg float-right m-2">Thêm</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên menu</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($menus as $key => $menu)
                                <tr>
                                    <th scope="row">
                                        {{ ($menus->currentPage() - 1) * $menus->perPage() + $key + 1 }}
                                    </th>
                                    <td>{{ $menu->name }}</td>
                                    <td>
                                        <a href="{{ route('menus.edit', ['id' => $menu->id]) }}" class="btn btn-default">Sửa</a>
                                        <a href="{{ route('menus.delete', ['id' => $menu->id]) }}" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">{{ $menus->links('pagination::bootstrap-4') }}</div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

