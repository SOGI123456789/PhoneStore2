<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá sản phẩm: {{ $product->name }} - PhoneStore</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    
    <!-- Customizable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/blue.css') }}">

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
</head>

<body class="cnt-home">
    <!-- HEADER -->
    @include('partials.headerKH')
    <!-- HEADER END -->

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li><a href="{{ route('product.detail', $product->id) }}">{{ \Str::limit($product->name, 30) }}</a></li>
                    <li class='active'>Tất cả đánh giá</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB END -->

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                    <!-- PRODUCT HEADER -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="{{ $product->image_link ? asset('storage/' . $product->image_link) : asset('assets/images/default-product.jpg') }}" 
                                         alt="{{ $product->name }}" class="img-responsive">
                                </div>
                                <div class="col-md-10">
                                    <h2>{{ $product->name }}</h2>
                                    <div class="product-rating-summary">
                                        <div class="rating-display">
                                            @for($i = 1; $i <= $product->full_stars; $i++)
                                                <i class="fa fa-star text-warning"></i>
                                            @endfor
                                            @if($product->has_half_star)
                                                <i class="fa fa-star-half-o text-warning"></i>
                                            @endif
                                            @for($i = 1; $i <= $product->empty_stars; $i++)
                                                <i class="fa fa-star-o text-muted"></i>
                                            @endfor
                                            <span class="rating-text">{{ $product->average_rating }}/5 ({{ $product->rate_count }} đánh giá)</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary">
                                        <i class="fa fa-arrow-left"></i> Về trang sản phẩm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- REVIEWS FILTERS AND SORT -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form method="GET" class="form-inline">
                                <div class="form-group">
                                    <label>Lọc theo đánh giá:</label>
                                    <select name="rating" class="form-control">
                                        <option value="">Tất cả</option>
                                        @for($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                                {{ $i }} sao
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Loại đánh giá:</label>
                                    <select name="filter" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="verified" {{ request('filter') == 'verified' ? 'selected' : '' }}>
                                            Đã xác minh
                                        </option>
                                        <option value="with_review" {{ request('filter') == 'with_review' ? 'selected' : '' }}>
                                            Có nội dung đánh giá
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Sắp xếp:</label>
                                    <select name="sort_by" class="form-control">
                                        <option value="newest" {{ $sortBy == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                        <option value="oldest" {{ $sortBy == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                        <option value="highest_rating" {{ $sortBy == 'highest_rating' ? 'selected' : '' }}>Đánh giá cao nhất</option>
                                        <option value="lowest_rating" {{ $sortBy == 'lowest_rating' ? 'selected' : '' }}>Đánh giá thấp nhất</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Áp dụng</button>
                            </form>
                        </div>
                    </div>

                    <!-- REVIEWS LIST -->
                    @if($reviews->count() > 0)
                    <div class="reviews-container">
                        @foreach($reviews as $review)
                        <div class="panel panel-default review-panel">
                            <div class="panel-body">
                                <div class="review-header">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h4>{{ $review->display_name }}</h4>
                                            @if($review->is_verified)
                                                <span class="label label-success">
                                                    <i class="fa fa-check"></i> Đã mua hàng
                                                </span>
                                            @endif
                                            <div class="review-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="review-content" style="margin-top: 15px;">
                                    @if($review->review)
                                        <p>{{ $review->review }}</p>
                                    @endif
                                    
                                    @if($review->pros)
                                        <div class="review-pros">
                                            <strong class="text-success">
                                                <i class="fa fa-thumbs-up"></i> Ưu điểm:
                                            </strong>
                                            <ul class="list-unstyled" style="margin-left: 20px;">
                                                @foreach($review->pros as $pro)
                                                    <li><i class="fa fa-plus text-success"></i> {{ $pro }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    
                                    @if($review->cons)
                                        <div class="review-cons">
                                            <strong class="text-danger">
                                                <i class="fa fa-thumbs-down"></i> Nhược điểm:
                                            </strong>
                                            <ul class="list-unstyled" style="margin-left: 20px;">
                                                @foreach($review->cons as $con)
                                                    <li><i class="fa fa-minus text-danger"></i> {{ $con }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- REVIEW ACTIONS -->
                                <div class="review-actions" style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee;">
                                    @auth
                                        @if(auth()->id() == $review->user_id && $review->canEdit(auth()->id()))
                                            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-default">
                                                <i class="fa fa-edit"></i> Chỉnh sửa
                                            </a>
                                            <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" style="display: inline;" 
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <!-- PAGINATION -->
                        <div class="text-center">
                            {{ $reviews->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @else
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <i class="fa fa-star-o" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                            <h4>Không có đánh giá nào phù hợp</h4>
                            <p class="text-muted">Thử thay đổi bộ lọc để xem thêm đánh giá</p>
                            <a href="?">Xem tất cả đánh giá</a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    @include('partials.footerKH')
    <!-- FOOTER END -->

    <!-- JavaScripts -->
    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <style>
    .review-panel {
        margin-bottom: 20px;
    }
    
    .review-rating {
        margin: 5px 0;
        font-size: 16px;
    }
    
    .review-pros, .review-cons {
        margin: 15px 0;
    }
    
    .product-rating-summary {
        margin: 10px 0;
    }
    
    .rating-display {
        font-size: 18px;
    }
    
    .rating-text {
        margin-left: 10px;
        font-size: 14px;
        color: #666;
    }
    
    .form-inline .form-group {
        margin-right: 15px;
        margin-bottom: 10px;
    }
    
    .form-inline label {
        margin-right: 5px;
        font-weight: normal;
    }
    
    @media (max-width: 768px) {
        .form-inline .form-group {
            display: block;
            margin-bottom: 15px;
        }
        
        .form-inline .form-control {
            width: 100%;
        }
    }
    </style>

</body>
</html>
