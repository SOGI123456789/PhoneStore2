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
        .verified-badge {
            background: #28a745;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
        .image-upload-area {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background: #fafafa;
            transition: border-color 0.3s;
        }
        .image-upload-area:hover {
            border-color: #007bff;
        }
        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }
        .image-preview-item {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #ddd;
        }
        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .image-remove-btn {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
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
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST" id="reviewForm" enctype="multipart/form-data">
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

                            <!-- Review Images -->
                            <div class="form-group">
                                <label class="control-label"><strong>Hình ảnh đánh giá</strong></label>
                                <div class="image-upload-area">
                                    <input type="file" name="images[]" id="reviewImages" class="form-control" 
                                           multiple accept="image/*" onchange="previewImages(this)">
                                    <small class="text-muted">Tối đa 5 hình ảnh, mỗi ảnh không quá 5MB (JPG, PNG, GIF)</small>
                                </div>
                                <div id="imagePreview" class="image-preview-container"></div>
                                @error('images')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @error('images.*')
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

        // Preview images function
        function previewImages(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            if (input.files) {
                // Limit to 5 images
                const files = Array.from(input.files).slice(0, 5);
                
                files.forEach(function(file, index) {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const previewItem = document.createElement('div');
                            previewItem.className = 'image-preview-item';
                            previewItem.innerHTML = `
                                <img src="${e.target.result}" alt="Preview ${index + 1}">
                                <button type="button" class="image-remove-btn" onclick="removeImage(${index})">&times;</button>
                            `;
                            preview.appendChild(previewItem);
                        };
                        
                        reader.readAsDataURL(file);
                    }
                });

                // Update file input if we limited the files
                if (input.files.length > 5) {
                    const dt = new DataTransfer();
                    files.forEach(file => dt.items.add(file));
                    input.files = dt.files;
                    alert('Chỉ được chọn tối đa 5 hình ảnh');
                }
            }
        }

        // Remove image function
        function removeImage(index) {
            const input = document.getElementById('reviewImages');
            const dt = new DataTransfer();
            
            Array.from(input.files).forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });
            
            input.files = dt.files;
            previewImages(input);
        }
    </script>

</body>
</html>
