@extends('layouts.admin')

@section('title', 'Sửa danh mục')

@section('content')
    <div class="content-wrapper">
        @include('partials.content-header',['name'=>'Categories','key'=>'Edit'])

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('categories.update', ['id' => $category->id]) }}" method="POST">
                            @csrf


                            <div class="form-group">
                                <label for="tenDanhMuc">Tên danh mục</label>
                                <input type="text" class="form-control" name="name" value="{{ $category->name }}" placeholder="Điền tên danh mục">
                            </div>

                            <div class="form-group">
                                <label for="danhMucCha">Chọn danh mục cha</label>
                                <select class="form-control" name="parent_id">
                                    <option value="0">Chọn danh mục cha</option>
                                    {!! $htmlOption !!}
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
