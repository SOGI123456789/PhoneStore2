@extends('layouts.admin')

@section('title', 'Quản lý Variants - ' . $product->name)

@section('content')
    <div class="content-wrapper">
        @include('partials.content-header',['name'=>'Product Variants','key'=>$product->name])
        
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-mobile-alt"></i> {{ $product->name }}
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ route('products.variants.create', $product->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Thêm Variant
                                    </a>
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Quay lại
                                    </a>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                @if($product->variants->isEmpty())
                                    <div class="text-center py-4">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <h5>Chưa có variant nào</h5>
                                        <p class="text-muted">Hãy thêm variant đầu tiên cho sản phẩm này</p>
                                        <a href="{{ route('products.variants.create', $product->id) }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Thêm Variant
                                        </a>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Màu sắc</th>
                                                    <th>RAM</th>
                                                    <th>ROM</th>
                                                    <th>Giá gốc</th>
                                                    <th>Giá khuyến mãi</th>
                                                    <th>Số lượng</th>
                                                    <th>Ảnh</th>
                                                    <th>Trạng thái</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($product->variants as $key => $variant)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>
                                                            @php
                                                                $colorName = strtolower($variant->color);
                                                                // Chuyển đổi tên màu tiếng Việt sang CSS color
                                                                $colorMap = [
                                                                    'đen' => 'black',
                                                                    'trắng' => 'white', 
                                                                    'đỏ' => 'red',
                                                                    'xanh' => 'blue',
                                                                    'xanh lá' => 'green',
                                                                    'vàng' => 'yellow',
                                                                    'tím' => 'purple',
                                                                    'hồng' => 'pink',
                                                                    'xám' => 'gray',
                                                                    'bạc' => 'silver',
                                                                    'vàng đồng' => 'gold',
                                                                    'xanh dương' => 'blue',
                                                                    'xanh lam' => 'cyan'
                                                                ];
                                                                $cssColor = $colorMap[$colorName] ?? $colorName;
                                                            @endphp
                                                            <span class="badge px-3 py-2 color-badge" style="background-color: {{ $cssColor }};">
                                                                {{ $variant->color }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $variant->ram }}</td>
                                                        <td>{{ $variant->rom }}</td>
                                                        <td>{{ number_format($variant->price) }} đ</td>
                                                        <td>
                                                            @if($variant->discount_price)
                                                                <span class="text-danger font-weight-bold">
                                                                    {{ number_format($variant->discount_price) }} đ
                                                                </span>
                                                            @else
                                                                <span class="text-muted">Không có</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($variant->quantity > 0)
                                                                <span class="badge badge-success">{{ $variant->quantity }}</span>
                                                            @else
                                                                <span class="badge badge-danger">Hết hàng</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($variant->image_link)
                                                                <img src="{{ asset('storage/' . $variant->image_link) }}" alt="Variant" width="50" class="rounded">
                                                            @else
                                                                <span class="text-muted">Không có</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($variant->isInStock())
                                                                <span class="badge badge-success">Còn hàng</span>
                                                            @else
                                                                <span class="badge badge-danger">Hết hàng</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('products.variants.edit', [$product->id, $variant->id]) }}" 
                                                                   class="btn btn-warning btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('products.variants.delete', [$product->id, $variant->id]) }}" 
                                                                      method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                                            onclick="return confirm('Bạn có chắc muốn xóa variant này?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-info"><i class="fas fa-cubes"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Tổng variants</span>
                                                        <span class="info-box-number">{{ $product->variants->count() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-success"><i class="fas fa-boxes"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Tổng tồn kho</span>
                                                        <span class="info-box-number">{{ $product->variants->sum('quantity') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<style>
    .color-badge {
        font-weight: 600;
        border-radius: 15px;
        border: 2px solid #ddd;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
    }
    
    .color-badge.light-color {
        color: #333 !important;
        text-shadow: none;
        border-color: #999;
    }
</style>

<script>
    // Thêm hiệu ứng hover cho table rows
    document.addEventListener('DOMContentLoaded', function() {
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
        
        // Xử lý màu sắc cho badges
        const colorBadges = document.querySelectorAll('.color-badge');
        colorBadges.forEach(badge => {
            const bgColor = window.getComputedStyle(badge).backgroundColor;
            // Tính độ sáng của màu
            const rgb = bgColor.match(/\d+/g);
            if (rgb) {
                const brightness = Math.round(((parseInt(rgb[0]) * 299) +
                                               (parseInt(rgb[1]) * 587) +
                                               (parseInt(rgb[2]) * 114)) / 1000);
                if (brightness > 125) {
                    badge.classList.add('light-color');
                }
            }
        });
    });
</script>
@endsection
