@extends('layouts.admin')

@section('title',)

@section('content')
    <div class="content-wrapper">
        @include('partials.content-header',['name'=>'menus','key'=>'Add'])

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('menus.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="tenDanhMuc">Tên Menu</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ old('name') }}" placeholder="Điền tên menu">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="danhMucCha">Chọn Menu phụ thuộc</label>
                                <select class="form-control" name="parent_id">
                                    <option value="0" {{ old('parent_id') == 0 ? 'selected' : '' }}>
                                        Chọn menu phụ thuộc
                                    </option>
                               {!! $optionSelected !!}
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
