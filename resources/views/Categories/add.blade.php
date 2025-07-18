@extends('layouts.admin')

@section('title', 'Thêm danh mục')

@section('content')
    <div class="content-wrapper">
        @include('partials.content-header',['name'=>'Categories','key'=>'Add'])

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="tenDanhMuc">Tên danh mục</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ old('name') }}" placeholder="Điền tên danh mục">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="danhMucCha">Chọn danh mục cha</label>
                                <select class="form-control" name="parent_id">
                                    <option value="0" {{ old('parent_id') == 0 ? 'selected' : '' }}>
                                        Chọn danh mục cha
                                    </option>
                                    {!! $htmlOption !!}
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
