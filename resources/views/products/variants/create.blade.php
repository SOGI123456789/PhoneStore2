@extends('layouts.admin')

@section('title', 'Thêm Variant - ' . $product->name)

@section('content')
    <div class="content-wrapper">
        @include('partials.content-header',['name'=>'Add Variant','key'=>$product->name])
        
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-plus"></i> Thêm Variant cho {{ $product->name }}
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

                                <form action="{{ route('products.variants.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="color">Màu sắc <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="color" 
                                                       value="{{ old('color') }}" required placeholder="VD: Đen, Trắng, Xanh...">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ram">RAM <span class="text-danger">*</span></label>
                                                <select class="form-control" name="ram" required>
                                                    <option value="">Chọn RAM</option>
                                                    <option value="4GB" {{ old('ram') == '4GB' ? 'selected' : '' }}>4GB</option>
                                                    <option value="6GB" {{ old('ram') == '6GB' ? 'selected' : '' }}>6GB</option>
                                                    <option value="8GB" {{ old('ram') == '8GB' ? 'selected' : '' }}>8GB</option>
                                                    <option value="12GB" {{ old('ram') == '12GB' ? 'selected' : '' }}>12GB</option>
                                                    <option value="16GB" {{ old('ram') == '16GB' ? 'selected' : '' }}>16GB</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="rom">ROM <span class="text-danger">*</span></label>
                                                <select class="form-control" name="rom" required>
                                                    <option value="">Chọn ROM</option>
                                                    <option value="64GB" {{ old('rom') == '64GB' ? 'selected' : '' }}>64GB</option>
                                                    <option value="128GB" {{ old('rom') == '128GB' ? 'selected' : '' }}>128GB</option>
                                                    <option value="256GB" {{ old('rom') == '256GB' ? 'selected' : '' }}>256GB</option>
                                                    <option value="512GB" {{ old('rom') == '512GB' ? 'selected' : '' }}>512GB</option>
                                                    <option value="1TB" {{ old('rom') == '1TB' ? 'selected' : '' }}>1TB</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price">Giá gốc (VND) <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="price" 
                                                       value="{{ old('price') }}" min="0" step="1000" required 
                                                       placeholder="VD: 10000000">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount_price">Giá khuyến mãi (VND)</label>
                                                <input type="number" class="form-control" name="discount_price" 
                                                       value="{{ old('discount_price') }}" min="0" step="1000" 
                                                       placeholder="VD: 9000000 (phải nhỏ hơn giá gốc)">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quantity">Số lượng <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="quantity" 
                                                       value="{{ old('quantity', 0) }}" min="0" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image_link">Ảnh variant</label>
                                                <input type="file" class="form-control" name="image_link" accept="image/*">
                                                <small class="form-text text-muted">
                                                    Ảnh riêng cho variant này (nếu khác với ảnh sản phẩm chính)
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h6><i class="fas fa-calculator"></i> Tính giá tự động</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Giá base (tham khảo):</label>
                                                        <input type="number" class="form-control" id="base-price" 
                                                               placeholder="VD: 10000000" step="1000">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Phụ thu RAM/ROM:</label>
                                                        <div class="btn-group-toggle" data-toggle="buttons">
                                                            <button type="button" class="btn btn-outline-info btn-sm" onclick="autoCalculatePrice()">
                                                                <i class="fas fa-magic"></i> Tính tự động
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> Lưu Variant
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
                                    <i class="fas fa-lightbulb"></i> Gợi ý
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="callout callout-info">
                                    <h6>Cách đặt giá:</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success"></i> RAM cao hơn +500k-1M</li>
                                        <li><i class="fas fa-check text-success"></i> ROM cao hơn +300k-800k</li>
                                        <li><i class="fas fa-check text-success"></i> Màu đặc biệt +100k-300k</li>
                                    </ul>
                                </div>
                                
                                <div class="callout callout-warning">
                                    <h6>Lưu ý:</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-exclamation-triangle text-warning"></i> Giá khuyến mãi phải nhỏ hơn giá gốc</li>
                                        <li><i class="fas fa-exclamation-triangle text-warning"></i> Tên màu nên đơn giản, dễ hiểu</li>
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
    
    // Tính giá tự động
    function autoCalculatePrice() {
        const basePrice = parseFloat(document.getElementById('base-price').value) || 0;
        const ram = document.querySelector('select[name="ram"]').value;
        const rom = document.querySelector('select[name="rom"]').value;
        
        if (basePrice <= 0) {
            alert('Vui lòng nhập giá base trước');
            return;
        }
        
        let finalPrice = basePrice;
        
        // Phụ thu RAM
        switch(ram) {
            case '6GB': finalPrice += 500000; break;
            case '8GB': finalPrice += 1000000; break;
            case '12GB': finalPrice += 2000000; break;
            case '16GB': finalPrice += 3000000; break;
        }
        
        // Phụ thu ROM
        switch(rom) {
            case '128GB': finalPrice += 300000; break;
            case '256GB': finalPrice += 800000; break;
            case '512GB': finalPrice += 1500000; break;
            case '1TB': finalPrice += 3000000; break;
        }
        
        document.querySelector('input[name="price"]').value = finalPrice;
    }
    
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
