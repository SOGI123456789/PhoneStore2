@extends('layouts.admin')   <!-- khi view home được load sẽ bắt đầu tìm layouts\admin để extend -->

@section('title', 'Tạo khuyến mại mới')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('partials.content-header',['name'=>'Promotions','key'=>'Create'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('promotions.index') }}" class="btn-secondary btn-lg float-right m-2">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                    <div class="col-md-12">
                        <form action="{{ route('promotions.store') }}" method="POST">
                            @csrf
                            <div class="form-content">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <!-- Thông tin cơ bản -->
                                    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Tiêu đề khuyến mại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="code">Mã khuyến mại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                           id="code" name="code" value="{{ old('code') }}" required 
                                           placeholder="VD: SALE2025">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Mã sẽ được tự động chuyển thành chữ hoa</small>
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                    </div>

                                    <!-- Cài đặt giảm giá -->
                                    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discount_type">Loại giảm giá <span class="text-danger">*</span></label>
                                    <select class="form-control @error('discount_type') is-invalid @enderror" 
                                            id="discount_type" name="discount_type" required>
                                        <option value="">Chọn loại giảm giá</option>
                                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>
                                            Phần trăm (%)
                                        </option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>
                                            Số tiền cố định (VNĐ)
                                        </option>
                                    </select>
                                    @error('discount_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="discount_value">Giá trị giảm giá <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('discount_value') is-invalid @enderror" 
                                               id="discount_value" name="discount_value" value="{{ old('discount_value') }}" 
                                               step="0.01" min="0" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="discount-unit">%</span>
                                        </div>
                                    </div>
                                    @error('discount_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="max_discount_amount">Số tiền giảm tối đa (VNĐ)</label>
                                    <input type="number" class="form-control @error('max_discount_amount') is-invalid @enderror" 
                                           id="max_discount_amount" name="max_discount_amount" 
                                           value="{{ old('max_discount_amount') }}" step="1000" min="0">
                                    @error('max_discount_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Để trống nếu chọn phần trăm</small>
                                </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Thời gian -->
                                    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Ngày bắt đầu <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="end_date">Ngày kết thúc <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Điều kiện -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usage_limit">Giới hạn số lần sử dụng</label>
                                    <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" 
                                           id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}" 
                                           min="1">
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Để trống nếu không giới hạn</small>
                                </div>

                                <div class="form-group">
                                    <label for="min_order_value">Giá trị đơn hàng tối thiểu (VNĐ)</label>
                                    <input type="number" class="form-control @error('min_order_value') is-invalid @enderror" 
                                           id="min_order_value" name="min_order_value" 
                                           value="{{ old('min_order_value') }}" step="1000" min="0">
                                    @error('min_order_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Để trống nếu không yêu cầu</small>
                                </div>
                                    </div>
                                </div>

                                <!-- Áp dụng cho -->
                                <div class="form-group">
                                    <label>Áp dụng cho <span class="text-danger">*</span></label>
                                    
                                    <!-- Radio buttons để chọn phạm vi -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="applies_to" id="applies_all" value="all" 
                                               {{ old('applies_to') == 'all' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="applies_all">
                                            <i class="fas fa-globe text-primary"></i> Tất cả sản phẩm
                                        </label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="applies_to" id="applies_products" value="specific_products"
                                               {{ old('applies_to') == 'specific_products' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="applies_products">
                                            <i class="fas fa-mobile-alt text-success"></i> Sản phẩm cụ thể
                                        </label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="applies_to" id="applies_categories" value="specific_categories"
                                               {{ old('applies_to') == 'specific_categories' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="applies_categories">
                                            <i class="fas fa-list text-warning"></i> Danh mục cụ thể
                                        </label>
                                    </div>
                                    
                                    @error('applies_to')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Chọn sản phẩm -->
                                <div class="form-group" id="products-section">
                                    <label>Chọn sản phẩm <span class="text-info">(Chọn theo mục áp dụng có thể chọn nhiều))</span></label>
                                    <div class="products-list" style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px;">
                                        @if(isset($products) && $products->count() > 0)
                                            @foreach($products as $product)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="products[]" 
                                                           id="product_{{ $product->id }}" value="{{ $product->id }}"
                                                           {{ in_array($product->id, old('products', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="product_{{ $product->id }}">
                                                        <i class="fas fa-mobile-alt text-info"></i> {{ $product->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">Không có sản phẩm nào</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Chọn danh mục -->
                                <div class="form-group" id="categories-section">
                                    <label>Chọn danh mục <span class="text-info">(Chọn theo mục áp dụng có thể chọn nhiều))</span></label>
                                    <div class="categories-list" style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px;">
                                        @if(isset($categories) && $categories->count() > 0)
                                            @foreach($categories as $category)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="categories[]" 
                                                           id="category_{{ $category->id }}" value="{{ $category->id }}"
                                                           {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                                        <i class="fas fa-folder text-warning"></i> {{ $category->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">Không có danh mục nào</p>
                                        @endif
                                    </div>
                                </div>                                <div class="form-actions mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Lưu khuyến mại
                                    </button>
                                    <a href="{{ route('promotions.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Hủy
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
<style>
.select2-container--bootstrap4 .select2-selection {
    border-color: #ced4da;
}
.select2-container .select2-selection--multiple {
    min-height: 38px;
}
#products-section, #categories-section {
    border: 2px solid #ddd;
    padding: 15px;
    border-radius: 5px;
    background-color: #f8f9fa;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

#products-section.highlight, #categories-section.highlight {
    border-color: #007bff;
    background-color: #e3f2fd;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
}

#products-section.disabled, #categories-section.disabled {
    border-color: #e9ecef;
    background-color: #f5f5f5;
    opacity: 0.6;
}

.form-check {
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 4px;
    transition: background-color 0.2s ease;
}

.form-check:hover {
    background-color: #f8f9fa;
}

.form-check-input:checked + .form-check-label {
    font-weight: 600;
    color: #007bff;
}

/* Styling cho products và categories lists */
.products-list, .categories-list {
    background-color: white;
}

.products-list .form-check, .categories-list .form-check {
    margin-bottom: 8px;
    padding: 6px 10px;
    border: 1px solid #e9ecef;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.products-list .form-check:hover, .categories-list .form-check:hover {
    background-color: #f8f9fa;
    border-color: #007bff;
}

.products-list .form-check-input:checked + .form-check-label,
.categories-list .form-check-input:checked + .form-check-label {
    color: #007bff;
    font-weight: 500;
}

.disabled .products-list .form-check,
.disabled .categories-list .form-check {
    opacity: 0.5;
    pointer-events: none;
}
.select2-container {
    width: 100% !important;
}
.select2-selection--multiple {
    min-height: 40px !important;
}
</style>

<script>
$(document).ready(function() {
    console.log('Document ready - initializing form');

    // Handle discount type change
    $('#discount_type').change(function() {
        const discountType = $(this).val();
        const unit = discountType === 'percentage' ? '%' : 'VNĐ';
        $('#discount-unit').text(unit);
        
        // Reset and set appropriate limits
        const discountValue = $('#discount_value');
        if (discountType === 'percentage') {
            discountValue.attr('max', 100);
        } else {
            discountValue.removeAttr('max');
        }
        console.log('Discount type changed to:', discountType);
    });

    // Handle applies_to radio button change
    $('input[name="applies_to"]').change(function() {
        const appliesTo = $(this).val();
        console.log('Applies to changed to:', appliesTo);
        
        // Reset all sections styling
        $('#products-section').removeClass('highlight disabled');
        $('#categories-section').removeClass('highlight disabled');
        
        // Apply styling based on selection
        if (appliesTo === 'specific_products') {
            $('#products-section').addClass('highlight');
            $('#categories-section').addClass('disabled');
            console.log('Highlighting products section');
        } else if (appliesTo === 'specific_categories') {
            $('#categories-section').addClass('highlight');
            $('#products-section').addClass('disabled');
            console.log('Highlighting categories section');
        } else if (appliesTo === 'all') {
            $('#products-section').addClass('disabled');
            $('#categories-section').addClass('disabled');
            console.log('All products selected - disabling specific selections');
        }
    });

    // Trigger change on page load to show/hide sections
    $('input[name="applies_to"]:checked').trigger('change');
    $('#discount_type').trigger('change');
    
    console.log('Form initialization complete');
});
</script>
@endsection
