// Search functionality enhancements
$(document).ready(function() {
    
    // Auto-submit search form when filters change
    $('.sidebar-widget input[type="radio"]').change(function() {
        $(this).closest('form').submit();
    });
    
    // Search suggestions (autocomplete)
    let searchTimeout;
    $('.search-field').on('input', function() {
        const query = $(this).val();
        const $searchField = $(this);
        
        clearTimeout(searchTimeout);
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(function() {
                $.ajax({
                    url: '/search/suggestions',
                    method: 'GET',
                    data: { q: query },
                    success: function(suggestions) {
                        showSuggestions($searchField, suggestions);
                    },
                    error: function() {
                        console.log('Error fetching suggestions');
                    }
                });
            }, 300);
        } else {
            hideSuggestions();
        }
    });
    
    // Hide suggestions when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('.search-suggestions-container').length) {
            hideSuggestions();
        }
    });
    
    function showSuggestions($searchField, suggestions) {
        hideSuggestions();
        
        if (suggestions.length === 0) return;
        
        const $container = $('<div class="search-suggestions-container"></div>');
        const $list = $('<ul class="search-suggestions-list"></ul>');
        
        suggestions.forEach(function(suggestion) {
            const $item = $('<li class="search-suggestion-item"></li>');
            $item.text(suggestion);
            $item.click(function() {
                $searchField.val(suggestion);
                $searchField.closest('form').submit();
            });
            $list.append($item);
        });
        
        $container.append($list);
        $searchField.closest('.control-group').append($container);
    }
    
    function hideSuggestions() {
        $('.search-suggestions-container').remove();
    }
    
    // Search form validation
    $('.search-area form').submit(function(e) {
        const query = $(this).find('.search-field').val().trim();
        if (query.length < 2) {
            e.preventDefault();
            alert('Vui lòng nhập ít nhất 2 ký tự để tìm kiếm');
            return false;
        }
    });
    
    // Product quick actions
    $('.add-to-cart').click(function(e) {
        e.preventDefault();
        const $btn = $(this);
        const $form = $btn.closest('form');
        
        // Add loading state
        $btn.prop('disabled', true);
        $btn.html('<i class="fa fa-spinner fa-spin"></i> Đang thêm...');
        
        // Submit form via AJAX
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                $btn.html('<i class="fa fa-check"></i> Đã thêm');
                setTimeout(function() {
                    $btn.prop('disabled', false);
                    $btn.html('<i class="fa fa-shopping-cart"></i> Thêm vào giỏ');
                }, 2000);
                
                // Update cart count if exists
                if (response.cartCount) {
                    $('.cart-count').text(response.cartCount);
                }
                
                // Show success message
                showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
            },
            error: function() {
                $btn.prop('disabled', false);
                $btn.html('<i class="fa fa-shopping-cart"></i> Thêm vào giỏ');
                showNotification('Có lỗi xảy ra, vui lòng thử lại!', 'error');
            }
        });
    });
    
    // Show notification function
    function showNotification(message, type) {
        const $notification = $('<div class="search-notification"></div>');
        $notification.addClass('notification-' + type);
        $notification.text(message);
        
        $('body').append($notification);
        
        setTimeout(function() {
            $notification.addClass('show');
        }, 100);
        
        setTimeout(function() {
            $notification.removeClass('show');
            setTimeout(function() {
                $notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Smooth scroll to top when pagination is clicked
    $('.pagination a').click(function(e) {
        setTimeout(function() {
            $('html, body').animate({
                scrollTop: $('.search-result-header').offset().top - 100
            }, 500);
        }, 100);
    });
    
    // Product image lazy loading
    $('.product-image img').each(function() {
        const $img = $(this);
        const src = $img.attr('src');
        
        $img.attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtc2l6ZT0iMTIiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5Đang tải...</dGV4dD48L3N2Zz4=');
        
        const img = new Image();
        img.onload = function() {
            $img.attr('src', src);
        };
        img.src = src;
    });
});
