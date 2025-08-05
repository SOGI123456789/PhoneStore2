@extends('layouts.admin')

@section('title', 'Sửa Variant - ' . $product->name)

@section('content')
    <div class="content-wrapper">
        @include('partials.content-header',['name'=>'Edit Variant','key'=>$product->name])
        
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-edit"></i> Sửa Variant: {{ $variant->color }} - {{ $variant->ram }}/{{ $variant->rom }}
                                </h3>
                            </div>
                            
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('products.variants.update', [$product->id, $variant->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="color">Màu sắc <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="color" 
                                                       value="{{ old('color', $variant->color) }}" required placeholder="VD: Đen, Trắng, Xanh...">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ram">RAM <span class="text-danger">*</span></label>
                                                <select class="form-control" name="ram" required>
                                                    <option value="">Chọn RAM</option>
                                                    <option value="4GB" {{ old('ram', $variant->ram) == '4GB' ? 'selected' : '' }}>4GB</option>
                                                    <option value="6GB" {{ old('ram', $variant->ram) == '6GB' ? 'selected' : '' }}>6GB</option>
                                                    <option value="8GB" {{ old('ram', $variant->ram) == '8GB' ? 'selected' : '' }}>8GB</option>
                                                    <option value="12GB" {{ old('ram', $variant->ram) == '12GB' ? 'selected' : '' }}>12GB</option>
                                                    <option value="16GB" {{ old('ram', $variant->ram) == '16GB' ? 'selected' : '' }}>16GB</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="rom">ROM <span class="text-danger">*</span></label>
                                                <select class="form-control" name="rom" required>
                                                    <option value="">Chọn ROM</option>
                                                    <option value="64GB" {{ old('rom', $variant->rom) == '64GB' ? 'selected' : '' }}>64GB</option>
                                                    <option value="128GB" {{ old('rom', $variant->rom) == '128GB' ? 'selected' : '' }}>128GB</option>
                                                    <option value="256GB" {{ old('rom', $variant->rom) == '256GB' ? 'selected' : '' }}>256GB</option>
                                                    <option value="512GB" {{ old('rom', $variant->rom) == '512GB' ? 'selected' : '' }}>512GB</option>
                                                    <option value="1TB" {{ old('rom', $variant->rom) == '1TB' ? 'selected' : '' }}>1TB</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price">Giá gốc (VND) <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="price" 
                                                       value="{{ old('price', $variant->price) }}" min="0" step="1000" required 
                                                       placeholder="VD: 10000000">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount_price">Giá khuyến mãi (VND)</label>
                                                <input type="number" class="form-control" name="discount_price" 
                                                       value="{{ old('discount_price', $variant->discount_price) }}" min="0" step="1000" 
                                                       placeholder="VD: 9000000 (phải nhỏ hơn giá gốc)">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quantity">Số lượng <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="quantity" 
                                                       value="{{ old('quantity', $variant->quantity) }}" min="0" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image_link">Ảnh variant</label>
                                                <input type="file" class="form-control" name="image_link" accept="image/*">
                                                @if($variant->image_link)
                                                    <div class="mt-2">
                                                        <img src="{{ asset('storage/' . $variant->image_link) }}" alt="Ảnh hiện tại" width="100" class="border rounded">
                                                        <small class="form-text text-muted">Ảnh hiện tại</small>
                                                    </div>
                                                @endif
                                                <small class="form-text text-muted">
                                                    Chọn ảnh mới để thay thế (nếu muốn)
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h6><i class="fas fa-info-circle"></i> Thông tin variant</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Giá hiển thị:</strong> 
                                                            <span class="text-success">
                                                                {{ number_format($variant->final_price) }} đ
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Trạng thái:</strong> 
                                                            @if($variant->isInStock())
                                                                <span class="badge badge-success">Còn hàng</span>
                                                            @else
                                                                <span class="badge badge-danger">Hết hàng</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> Cập nhật Variant
                                        </button>
                                        <a href="{{ route('products.variants', $product->id) }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Quay lại
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-line"></i> Thống kê
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-tag"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Giá bán</span>
                                        <span class="info-box-number">{{ number_format($variant->final_price) }} đ</span>
                                    </div>
                                </div>
                                
                                @if($variant->discount_price)
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="fas fa-percentage"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Tiết kiệm</span>
                                            <span class="info-box-number">
                                                {{ number_format($variant->price - $variant->discount_price) }} đ
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="callout callout-info">
                                    <h6>Lưu ý:</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success"></i> Thay đổi sẽ áp dụng ngay lập tức</li>
                                        <li><i class="fas fa-check text-success"></i> Khách hàng sẽ thấy giá mới</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
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
        const priceInput = document.querySelector('input[name="price"]');
        const discountInput = document.querySelector('input[name="discount_price"]');
        
        // Preview ảnh
        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
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
        
        // Validate giá khuyến mãi
        if (discountInput && priceInput) {
            discountInput.addEventListener('input', function() {
                const price = parseFloat(priceInput.value) || 0;
                const discount = parseFloat(this.value) || 0;
                
                if (discount > 0 && discount >= price) {
                    this.setCustomValidity('Giá khuyến mãi phải nhỏ hơn giá gốc');
                    this.classList.add('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                }
            });
        }
    });
    
    // Format số khi nhập
    document.querySelectorAll('input[type="number"][step="1000"]').forEach(input => {
        input.addEventListener('input', function() {
            // Đảm bảo số chia hết cho 1000
            let value = parseInt(this.value);
            if (value && value % 1000 !== 0) {
                this.value = Math.round(value / 1000) * 1000;
            }
        });
    });
</script>
@endsection
