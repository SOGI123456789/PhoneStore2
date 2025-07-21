<!-- PRODUCT REVIEWS SECTION -->
<div class="row" style="margin-top: 40px;">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-star text-warning"></i> Đánh giá sản phẩm
                    <span class="badge pull-right">{{ $product->rate_count }} đánh giá</span>
                    @if($product->rate_count > 0)
                        <a href="{{ route('reviews.index', $product->id) }}" class="btn btn-link btn-sm pull-right" style="margin-right: 10px;">
                            Xem tất cả <i class="fa fa-arrow-right"></i>
                        </a>
                    @endif
                </h3>
            </div>
            <div class="panel-body">
                
                <!-- RATING SUMMARY -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="rating-summary text-center">
                            <div class="average-rating">
                                <span class="rating-number">{{ $product->average_rating }}</span>
                                <small>/5</small>
                            </div>
                            <div class="stars-display">
                                @for($i = 1; $i <= $product->full_stars; $i++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor
                                @if($product->has_half_star)
                                    <i class="fa fa-star-half-o text-warning"></i>
                                @endif
                                @for($i = 1; $i <= $product->empty_stars; $i++)
                                    <i class="fa fa-star-o text-muted"></i>
                                @endfor
                            </div>
                            <p class="text-muted">{{ $product->rate_count }} đánh giá</p>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <!-- RATING BREAKDOWN -->
                        <div class="rating-breakdown">
                            @foreach($product->rating_percentages as $rating => $percentage)
                            <div class="rating-bar">
                                <span class="rating-label">{{ $rating }} <i class="fa fa-star text-warning"></i></span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-warning" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="rating-percentage">{{ $percentage }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <!-- WRITE REVIEW BUTTON -->
                        @auth
                            @php
                                $userReview = $product->reviews()->where('user_id', auth()->id())->first();
                            @endphp
                            
                            @if($userReview)
                                <div class="alert alert-success">
                                    <i class="fa fa-check"></i> Bạn đã đánh giá sản phẩm này
                                    <br>
                                    <small>
                                        <a href="{{ route('reviews.edit', $userReview->id) }}" class="btn btn-link btn-sm">
                                            <i class="fa fa-edit"></i> Chỉnh sửa
                                        </a>
                                    </small>
                                </div>
                            @else
                                <a href="{{ route('reviews.create', $product->id) }}" class="btn btn-primary btn-block">
                                    <i class="fa fa-star"></i> Viết đánh giá
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                                <i class="fa fa-sign-in"></i> Đăng nhập để đánh giá
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- REVIEWS LIST -->
                @if($product->approvedReviews->count() > 0)
                <div class="reviews-list" style="margin-top: 30px;">
                    <h4>Đánh giá từ khách hàng</h4>
                    
                    <!-- REVIEW FILTERS -->
                    <div class="review-filters" style="margin: 20px 0;">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-sm filter-btn" data-filter="all">
                                Tất cả ({{ $product->rate_count }})
                            </button>
                            @for($i = 5; $i >= 1; $i--)
                                @php $count = $product->reviews()->where('rating', $i)->count(); @endphp
                                @if($count > 0)
                                <button type="button" class="btn btn-default btn-sm filter-btn" data-filter="{{ $i }}">
                                    {{ $i }} <i class="fa fa-star"></i> ({{ $count }})
                                </button>
                                @endif
                            @endfor
                            <button type="button" class="btn btn-default btn-sm filter-btn" data-filter="verified">
                                <i class="fa fa-check"></i> Đã xác minh
                            </button>
                        </div>
                    </div>

                    <!-- INDIVIDUAL REVIEWS -->
                    @foreach($product->approvedReviews()->latest()->take(5)->get() as $review)
                    <div class="review-item" data-rating="{{ $review->rating }}" data-verified="{{ $review->is_verified ? 'true' : 'false' }}">
                        <div class="review-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <strong>{{ $review->display_name }}</strong>
                                    @if($review->is_verified)
                                        <span class="badge badge-success">
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
                        
                        <div class="review-content" style="margin-top: 10px;">
                            @if($review->review)
                                <p>{{ $review->review }}</p>
                            @endif
                            
                            @if($review->pros)
                                <div class="review-pros">
                                    <strong class="text-success">
                                        <i class="fa fa-thumbs-up"></i> Ưu điểm:
                                    </strong>
                                    <ul class="list-unstyled">
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
                                    <ul class="list-unstyled">
                                        @foreach($review->cons as $con)
                                            <li><i class="fa fa-minus text-danger"></i> {{ $con }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if($review->images && count($review->images) > 0)
                                <div class="review-images" style="margin-top: 15px;">
                                    <strong><i class="fa fa-camera"></i> Hình ảnh từ khách hàng:</strong>
                                    <div class="review-images-gallery" style="margin-top: 10px;">
                                        @foreach($review->images as $image)
                                            <div class="review-image-item" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     alt="Review Image" 
                                                     class="img-thumbnail review-image-thumb" 
                                                     style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                                     onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- REVIEW ACTIONS -->
                        <div class="review-actions" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                            <button class="btn btn-link btn-sm helpful-btn" data-review="{{ $review->id }}">
                                <i class="fa fa-thumbs-up"></i> Hữu ích
                            </button>
                            @if(auth()->check() && auth()->id() == $review->user_id && $review->canEdit(auth()->id()))
                                <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-link btn-sm">
                                    <i class="fa fa-edit"></i> Chỉnh sửa
                                </a>
                            @endif
                        </div>
                    </div>
                    <hr>
                    @endforeach

                    <!-- VIEW ALL REVIEWS BUTTON -->
                    @if($product->rate_count > 5)
                    <div class="text-center">
                        <a href="{{ route('reviews.index', $product->id) }}" class="btn btn-default">
                            <i class="fa fa-eye"></i> Xem tất cả {{ $product->rate_count }} đánh giá
                        </a>
                    </div>
                    @endif
                </div>
                @else
                <div class="no-reviews text-center" style="padding: 40px 0;">
                    <i class="fa fa-star-o" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                    <h4>Chưa có đánh giá nào</h4>
                    <p class="text-muted">Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                    @auth
                        <a href="{{ route('reviews.create', $product->id) }}" class="btn btn-primary">
                            <i class="fa fa-star"></i> Viết đánh giá đầu tiên
                        </a>
                    @endauth
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- CUSTOM CSS FOR REVIEWS -->
<style>
.rating-summary .rating-number {
    font-size: 48px;
    font-weight: bold;
    color: #f39c12;
}

.rating-summary .stars-display {
    font-size: 20px;
    margin: 10px 0;
}

.rating-breakdown .rating-bar {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    font-size: 14px;
}

.rating-breakdown .rating-label {
    width: 60px;
    text-align: right;
    margin-right: 10px;
}

.rating-breakdown .progress {
    flex: 1;
    height: 8px;
    margin: 0 10px;
}

.rating-breakdown .rating-percentage {
    width: 40px;
    font-size: 12px;
}

.review-item {
    padding: 20px 0;
}

.review-rating {
    margin: 5px 0;
}

.review-pros, .review-cons {
    margin: 10px 0;
}

.review-pros ul, .review-cons ul {
    margin: 5px 0;
    padding-left: 20px;
}

.filter-btn.active {
    background-color: #337ab7;
    color: white;
}

.helpful-btn:hover {
    color: #337ab7;
}

@media (max-width: 768px) {
    .rating-summary .rating-number {
        font-size: 36px;
    }
    
    .rating-breakdown .rating-bar {
        flex-direction: column;
        align-items: stretch;
        margin-bottom: 15px;
    }
    
    .rating-breakdown .rating-label,
    .rating-breakdown .rating-percentage {
        width: auto;
        text-align: center;
    }
    
    .rating-breakdown .progress {
        margin: 5px 0;
    }
}
</style>

<!-- JAVASCRIPT FOR REVIEWS -->
<script>
$(document).ready(function() {
    // Review filter functionality
    $('.filter-btn').click(function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        var filter = $(this).data('filter');
        
        if (filter === 'all') {
            $('.review-item').show();
        } else if (filter === 'verified') {
            $('.review-item').hide();
            $('.review-item[data-verified="true"]').show();
        } else {
            $('.review-item').hide();
            $('.review-item[data-rating="' + filter + '"]').show();
        }
    });
    
    // Helpful button
    $('.helpful-btn').click(function() {
        var reviewId = $(this).data('review');
        var btn = $(this);
        
        $.ajax({
            url: '/reviews/' + reviewId + '/helpful',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                btn.addClass('text-success');
                btn.prop('disabled', true);
                btn.html('<i class="fa fa-check"></i> Đã đánh dấu hữu ích');
            },
            error: function() {
                alert('Có lỗi xảy ra, vui lòng thử lại');
            }
        });
    });
});

// Image modal function
function openImageModal(imageSrc) {
    // Create modal if not exists
    if (!document.getElementById('imageModal')) {
        var modal = document.createElement('div');
        modal.id = 'imageModal';
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Hình ảnh đánh giá</h4>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-responsive" style="max-width: 100%; max-height: 500px;">
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }
    
    // Set image source and show modal
    document.getElementById('modalImage').src = imageSrc;
    $('#imageModal').modal('show');
}
</script>
