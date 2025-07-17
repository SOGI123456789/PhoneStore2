$(document).ready(function() {
    
    // Star rating functionality
    $('.star-rating .star').on('click', function() {
        var rating = $(this).data('rating');
        var container = $(this).closest('.star-rating');
        
        // Update hidden input
        container.find('input[name="rating"]').val(rating);
        
        // Update visual stars
        container.find('.star').each(function(index) {
            if (index < rating) {
                $(this).addClass('active').removeClass('text-muted').addClass('text-warning');
            } else {
                $(this).removeClass('active').removeClass('text-warning').addClass('text-muted');
            }
        });
        
        // Update rating label
        var labels = ['', 'Rất tệ', 'Tệ', 'Bình thường', 'Tốt', 'Rất tốt'];
        container.find('.rating-label').text(labels[rating] || '');
    });
    
    // Star rating hover effect
    $('.star-rating .star').on('mouseenter', function() {
        var rating = $(this).data('rating');
        var container = $(this).closest('.star-rating');
        
        container.find('.star').each(function(index) {
            if (index < rating) {
                $(this).removeClass('text-muted').addClass('text-warning');
            } else {
                $(this).removeClass('text-warning').addClass('text-muted');
            }
        });
    });
    
    $('.star-rating').on('mouseleave', function() {
        var rating = $(this).find('input[name="rating"]').val();
        var container = $(this);
        
        container.find('.star').each(function(index) {
            if (index < rating) {
                $(this).removeClass('text-muted').addClass('text-warning active');
            } else {
                $(this).removeClass('text-warning active').addClass('text-muted');
            }
        });
    });
    
    // Character counter for textareas
    function updateCharCount(textarea) {
        var maxLength = textarea.attr('maxlength');
        var currentLength = textarea.val().length;
        var counter = textarea.siblings('.char-count');
        
        if (counter.length === 0) {
            counter = $('<div class="char-count"></div>');
            textarea.after(counter);
        }
        
        counter.text(currentLength + '/' + maxLength);
        
        // Add warning/error classes
        counter.removeClass('warning error');
        if (currentLength > maxLength * 0.9) {
            counter.addClass('warning');
        }
        if (currentLength >= maxLength) {
            counter.addClass('error');
        }
    }
    
    // Initialize character counters
    $('textarea[maxlength]').each(function() {
        updateCharCount($(this));
    });
    
    $('textarea[maxlength]').on('input keyup', function() {
        updateCharCount($(this));
    });
    
    // Dynamic pros/cons input
    $('.add-pro-btn').on('click', function() {
        var container = $(this).siblings('.pros-container');
        var index = container.children().length;
        var newInput = $('<div class="input-group" style="margin-bottom: 10px;">' +
            '<input type="text" name="pros[]" class="form-control" placeholder="Ưu điểm...">' +
            '<span class="input-group-btn">' +
                '<button type="button" class="btn btn-danger remove-input">' +
                    '<i class="fa fa-times"></i>' +
                '</button>' +
            '</span>' +
        '</div>');
        
        container.append(newInput);
    });
    
    $('.add-con-btn').on('click', function() {
        var container = $(this).siblings('.cons-container');
        var index = container.children().length;
        var newInput = $('<div class="input-group" style="margin-bottom: 10px;">' +
            '<input type="text" name="cons[]" class="form-control" placeholder="Nhược điểm...">' +
            '<span class="input-group-btn">' +
                '<button type="button" class="btn btn-danger remove-input">' +
                    '<i class="fa fa-times"></i>' +
                '</button>' +
            '</span>' +
        '</div>');
        
        container.append(newInput);
    });
    
    // Remove pros/cons input
    $(document).on('click', '.remove-input', function() {
        $(this).closest('.input-group').remove();
    });
    
    // Review form validation
    $('.review-form form').on('submit', function(e) {
        var rating = $(this).find('input[name="rating"]').val();
        var hasError = false;
        
        // Clear previous errors
        $(this).find('.has-error').removeClass('has-error');
        $(this).find('.help-block').remove();
        
        // Validate rating
        if (!rating || rating < 1) {
            $(this).find('.star-rating').addClass('has-error')
                .append('<div class="help-block">Vui lòng chọn số sao đánh giá</div>');
            hasError = true;
        }
        
        // Validate review content (optional but if provided, must be at least 10 characters)
        var reviewText = $(this).find('textarea[name="review"]').val().trim();
        if (reviewText && reviewText.length < 10) {
            $(this).find('textarea[name="review"]').closest('.form-group').addClass('has-error')
                .append('<div class="help-block">Nội dung đánh giá phải có ít nhất 10 ký tự</div>');
            hasError = true;
        }
        
        if (hasError) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.has-error').first().offset().top - 100
            }, 500);
        }
    });
    
    // Helpful button functionality
    $('.helpful-btn').on('click', function(e) {
        e.preventDefault();
        
        var btn = $(this);
        var reviewId = btn.data('review-id');
        var isHelpful = btn.hasClass('active');
        
        // Toggle button state immediately for better UX
        btn.toggleClass('active');
        
        // Send AJAX request
        $.ajax({
            url: '/reviews/' + reviewId + '/helpful',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                helpful: !isHelpful
            },
            success: function(response) {
                // Update helpful count if provided
                if (response.helpful_count !== undefined) {
                    btn.find('.count').text(response.helpful_count);
                }
            },
            error: function() {
                // Revert button state on error
                btn.toggleClass('active');
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
    
    // Review filter auto-submit
    $('.review-filters select').on('change', function() {
        $(this).closest('form').submit();
    });
    
    // Smooth scroll to reviews section
    $('a[href="#reviews"]').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $('#reviews').offset().top - 80
        }, 500);
    });
    
    // Image preview for review attachments (if implemented later)
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = $(input).siblings('.image-preview');
                if (preview.length === 0) {
                    preview = $('<div class="image-preview"></div>');
                    $(input).after(preview);
                }
                preview.html('<img src="' + e.target.result + '" style="max-width: 200px; margin-top: 10px;">');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $('input[type="file"]').on('change', function() {
        previewImage(this);
    });
    
    // Confirm deletion
    $('.delete-review-btn').on('click', function(e) {
        if (!confirm('Bạn có chắc chắn muốn xóa đánh giá này?')) {
            e.preventDefault();
        }
    });
    
    // Auto-resize textareas
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }
    
    $('textarea').each(function() {
        autoResize(this);
    });
    
    $('textarea').on('input', function() {
        autoResize(this);
    });
    
    // Initialize tooltips if Bootstrap is available
    if (typeof $().tooltip === 'function') {
        $('[data-toggle="tooltip"]').tooltip();
    }
    
    // Initialize star ratings from existing values
    $('.star-rating').each(function() {
        var rating = $(this).find('input[name="rating"]').val();
        if (rating) {
            $(this).find('.star').each(function(index) {
                if (index < rating) {
                    $(this).addClass('active').removeClass('text-muted').addClass('text-warning');
                }
            });
            
            var labels = ['', 'Rất tệ', 'Tệ', 'Bình thường', 'Tốt', 'Rất tốt'];
            $(this).find('.rating-label').text(labels[rating] || '');
        }
    });
    
    // Animate rating bars on page load
    setTimeout(function() {
        $('.rating-fill').each(function() {
            var width = $(this).data('width') || 0;
            $(this).animate({width: width + '%'}, 1000);
        });
    }, 500);
    
});

// Helper function to format rating display
function formatRating(rating) {
    return parseFloat(rating).toFixed(1);
}

// Helper function to generate star HTML
function generateStars(rating, maxStars = 5) {
    var stars = '';
    var fullStars = Math.floor(rating);
    var hasHalfStar = rating % 1 >= 0.5;
    var emptyStars = maxStars - fullStars - (hasHalfStar ? 1 : 0);
    
    // Full stars
    for (var i = 0; i < fullStars; i++) {
        stars += '<i class="fa fa-star text-warning"></i>';
    }
    
    // Half star
    if (hasHalfStar) {
        stars += '<i class="fa fa-star-half-o text-warning"></i>';
    }
    
    // Empty stars
    for (var i = 0; i < emptyStars; i++) {
        stars += '<i class="fa fa-star-o text-muted"></i>';
    }
    
    return stars;
}
