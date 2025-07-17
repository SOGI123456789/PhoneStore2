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

    <!-- Custom Review CSS -->
    <style>
        .rating-stars {
            font-size: 2rem;
            color: #ddd;
        }
        .rating-stars .star {
            cursor: pointer;
            transition: color 0.2s;
        }
        .rating-stars .star:hover,
        .rating-stars .star.active {
            color: #ffc107;
        }
        .review-form {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: 20px 0;
        }
        .product-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .pros-cons-input {
            margin-bottom: 10px;
        }
        .add-item-btn {
            background: none;
            border: 1px dashed #007bff;
            color: #007bff;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .remove-item-btn {
            background: #dc3545;
            border: none;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 12px;
        }
        .verified-badge {
            background: #28a745;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
    </style>
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
                    <li class='active'>Đánh giá sản phẩm</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB END -->

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    
                    <!-- PRODUCT INFO -->
                    <div class="product-info">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ $product->image_link ? asset('storage/' . $product->image_link) : asset('assets/images/default-product.jpg') }}" 
                                     alt="{{ $product->name }}" class="img-responsive">
                            </div>
                            <div class="col-md-9">
                                <h3>{{ $product->name }}</h3>
                                <p class="text-primary"><strong>{{ number_format($product->price, 0, ',', '.') }}đ</strong></p>
                                @if($hasPurchased)
                                    <span class="verified-badge">
                                        <i class="fa fa-check"></i> Đã mua sản phẩm
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- REVIEW FORM -->
                    <div class="review-form">
                        <h2>Đánh giá sản phẩm</h2>
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST" id="reviewForm">
                            @csrf

                            <!-- Rating -->
                            <div class="form-group">
                                <label class="control-label"><strong>Đánh giá tổng thể <span class="text-danger">*</span></strong></label>
                                <div class="rating-stars" id="ratingStars">
                                    <span class="star" data-rating="1">★</span>
                                    <span class="star" data-rating="2">★</span>
                                    <span class="star" data-rating="3">★</span>
                                    <span class="star" data-rating="4">★</span>
                                    <span class="star" data-rating="5">★</span>
                                </div>
                                <input type="hidden" name="rating" id="rating" required>
                                <small class="text-muted" id="ratingText">Nhấp vào sao để đánh giá</small>
                                @error('rating')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Review Content -->
                            <div class="form-group">
                                <label class="control-label"><strong>Nội dung đánh giá</strong></label>
                                <textarea name="review" class="form-control" rows="5" 
                                          placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này...">{{ old('review') }}</textarea>
                                <small class="text-muted">Tối đa 1000 ký tự</small>
                                @error('review')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pros -->
                            <div class="form-group">
                                <label class="control-label"><strong>Ưu điểm</strong></label>
                                <div id="prosContainer">
                                    <div class="pros-cons-input">
                                        <div class="input-group">
                                            <input type="text" name="pros[]" class="form-control" placeholder="Ví dụ: Pin tốt, camera sắc nét...">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn remove-item-btn" onclick="removeItem(this)" style="display:none;">Xóa</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="add-item-btn" onclick="addProsItem()">
                                    <i class="fa fa-plus"></i> Thêm ưu điểm
                                </button>
                            </div>

                            <!-- Cons -->
                            <div class="form-group">
                                <label class="control-label"><strong>Nhược điểm</strong></label>
                                <div id="consContainer">
                                    <div class="pros-cons-input">
                                        <div class="input-group">
                                            <input type="text" name="cons[]" class="form-control" placeholder="Ví dụ: Giá cao, thiết kế cũ...">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn remove-item-btn" onclick="removeItem(this)" style="display:none;">Xóa</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="add-item-btn" onclick="addConsItem()">
                                    <i class="fa fa-plus"></i> Thêm nhược điểm
                                </button>
                            </div>

                            <!-- Reviewer Name -->
                            <div class="form-group">
                                <label class="control-label"><strong>Tên hiển thị</strong></label>
                                <input type="text" name="reviewer_name" class="form-control" 
                                       placeholder="Để trống sẽ hiển thị tên mặc định" value="{{ old('reviewer_name') }}">
                                <small class="text-muted">Tên này sẽ hiển thị công khai với đánh giá của bạn</small>
                                @error('reviewer_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Buttons -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa fa-star"></i> Gửi đánh giá
                                </button>
                                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-default btn-lg">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </form>
                    </div>

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

    <script>
        $(document).ready(function() {
            // Rating stars functionality
            $('.star').click(function() {
                var rating = $(this).data('rating');
                $('#rating').val(rating);
                
                $('.star').removeClass('active');
                for(var i = 1; i <= rating; i++) {
                    $('.star[data-rating="' + i + '"]').addClass('active');
                }
                
                // Update rating text
                var texts = {
                    1: 'Rất không hài lòng',
                    2: 'Không hài lòng', 
                    3: 'Bình thường',
                    4: 'Hài lòng',
                    5: 'Rất hài lòng'
                };
                $('#ratingText').text(rating + ' sao - ' + texts[rating]);
            });

            // Hover effect for stars
            $('.star').hover(function() {
                var rating = $(this).data('rating');
                $('.star').removeClass('hover');
                for(var i = 1; i <= rating; i++) {
                    $('.star[data-rating="' + i + '"]').addClass('hover');
                }
            }, function() {
                $('.star').removeClass('hover');
            });

            // Form validation
            $('#reviewForm').submit(function(e) {
                if (!$('#rating').val()) {
                    e.preventDefault();
                    alert('Vui lòng chọn số sao đánh giá');
                    return false;
                }
            });
        });

        // Add pros item
        function addProsItem() {
            var html = '<div class="pros-cons-input">' +
                '<div class="input-group">' +
                    '<input type="text" name="pros[]" class="form-control" placeholder="Nhập ưu điểm...">' +
                    '<span class="input-group-btn">' +
                        '<button type="button" class="btn remove-item-btn" onclick="removeItem(this)">Xóa</button>' +
                    '</span>' +
                '</div>' +
            '</div>';
            $('#prosContainer').append(html);
            updateRemoveButtons('#prosContainer');
        }

        // Add cons item  
        function addConsItem() {
            var html = '<div class="pros-cons-input">' +
                '<div class="input-group">' +
                    '<input type="text" name="cons[]" class="form-control" placeholder="Nhập nhược điểm...">' +
                    '<span class="input-group-btn">' +
                        '<button type="button" class="btn remove-item-btn" onclick="removeItem(this)">Xóa</button>' +
                    '</span>' +
                '</div>' +
            '</div>';
            $('#consContainer').append(html);
            updateRemoveButtons('#consContainer');
        }

        // Remove item
        function removeItem(btn) {
            $(btn).closest('.pros-cons-input').remove();
            updateRemoveButtons($(btn).closest('[id$="Container"]').attr('id'));
        }

        // Update remove buttons visibility
        function updateRemoveButtons(container) {
            var items = $(container + ' .pros-cons-input');
            if (items.length <= 1) {
                items.find('.remove-item-btn').hide();
            } else {
                items.find('.remove-item-btn').show();
            }
        }
    </script>

</body>
</html>
