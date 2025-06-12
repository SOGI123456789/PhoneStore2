
@extends('layouts.admin')   <!-- khi view home được load sẽ bắt đầu tìm layouts\admin để extend -->

@section('title', )
<title>Trang chủ</title>
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Starter Page</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Thêm Danh Mục</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12"> <!-- Thay col-m-6 bằng col-12 -->
                        <form>
                            <div class="form-group">
                                <label for="tenDanhMuc">Tên danh mục</label>
                                <input type="text" class="form-control" id="tenDanhMuc" placeholder="Điền tên danh mục">
                            </div>
                            <div class="form-group">
                                <label for="danhMucCha">Chọn danh mục cha</label>
                                <select class="form-control" id="danhMucCha">
                                    <option value="0">Chọn danh mục cha</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

