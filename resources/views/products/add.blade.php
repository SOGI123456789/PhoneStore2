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
                                <label for="catalog_id">Danh mục sản phẩm</label>
                                <select name="catalog_id" class="form-control" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('catalog_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="brand">Thương hiệu</label>
                                <input type="text" class="form-control" name="brand" value="{{ old('brand') }}" placeholder="VD: Apple, Samsung...">
                            </div>
                            
                            <div class="form-group">
                                <label for="content">Mô tả sản phẩm</label>
                                <textarea class="form-control" name="content" rows="4" placeholder="Mô tả chi tiết về sản phẩm...">{{ old('content') }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="image_link">Ảnh sản phẩm chính</label>
                                <input type="file" class="form-control" name="image_link" accept="image/*">
                                <small class="form-text text-muted">Chọn ảnh đại diện cho sản phẩm (jpeg, png, jpg, gif, svg tối đa 2MB)</small>
                            </div>
                            
                            <div class="alert alert-info">
                                <strong>Lưu ý:</strong> Sau khi tạo sản phẩm, bạn cần thêm các variants (màu sắc, RAM, ROM, giá) để khách hàng có thể mua sản phẩm.
                            </div>
                            
                            <button type="submit" class="btn btn-success">Tạo sản phẩm</button>
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
    // Preview ảnh khi chọn file
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.querySelector('input[name="image_link"]');
        
        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Tạo hoặc cập nhật preview
                        let preview = document.getElementById('image-preview');
                        if (!preview) {
                            preview = document.createElement('img');
                            preview.id = 'image-preview';
                            preview.style.marginTop = '10px';
                            preview.style.maxWidth = '200px';
                            preview.style.border = '1px solid #ddd';
                            preview.style.borderRadius = '4px';
                            imageInput.parentNode.appendChild(preview);
                        }
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endsection