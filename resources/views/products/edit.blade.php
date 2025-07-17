{{-- filepath: resources/views/products/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')

@section('content')
    <div class="content-wrapper">
        @include('partials.content-header',['name'=>'Products','key'=>'Edit'])
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

                        <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Mô tả</label>
                                <textarea class="form-control" name="content">{{ old('content', $product->content) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input type="number" class="form-control" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Số lượng</label>
                                <input type="number" class="form-control" name="quantity" value="{{ old('quantity', $product->quantity) }}" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="catalog_id">Danh mục sản phẩm</label>
                                <select name="catalog_id" class="form-control" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('catalog_id', $product->catalog_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image_link">Ảnh sản phẩm</label>
                                <input type="file" class="form-control" name="image_link">
                                @if($product->image_link)
                                    <img src="{{ asset('storage/' . $product->image_link) }}" alt="Ảnh" width="80">
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
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