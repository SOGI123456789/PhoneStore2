@extends('layouts.admin')

@section('title')

@section('content')
    <div class="content-wrapper">
        @include('partials.content-header',['name'=>'Products','key'=>'Add'])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Mô tả</label>
                                <textarea class="form-control" name="content">{{ old('content') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input type="number" class="form-control" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Số lượng</label>
                                <input type="number" class="form-control" name="quantity" value="{{ old('quantity', 0) }}" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="image_link">Ảnh sản phẩm</label>
                                <input type="file" class="form-control" name="image_link">
                                @if(isset($product) && $product->image_link)
                                    <img src="{{ asset('storage/' . $product->image_link) }}" alt="Ảnh" width="80">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="catalog_id">Danh mục sản phẩm</label>
                                <select name="catalog_id" class="form-control" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondsary">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Ngăn chặn nhập số âm
    document.addEventListener('DOMContentLoaded', function() {
        const numberInputs = document.querySelectorAll('input[type="number"]');
        
        numberInputs.forEach(function(input) {
            if (input.name === 'price' || input.name === 'quantity') {
                input.addEventListener('input', function() {
                    if (parseFloat(this.value) < 0) {
                        this.value = 0;
                    }
                });
                
                input.addEventListener('keypress', function(e) {
                    // Ngăn chặn nhập dấu trừ
                    if (e.key === '-') {
                        e.preventDefault();
                    }
                });
            }
        });
    });
</script>
@endsection