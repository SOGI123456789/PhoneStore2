<!-- Promotion Section for Checkout -->
<div class="promotion-section">
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-tags text-primary"></i> Khuyến mại
            </h5>
        </div>
        <div class="card-body">
            <!-- Promotion Messages -->
            <div id="promotion-messages"></div>

            <!-- Current Promotion Display -->
            <div id="promotion-display"></div>

            <!-- Promotion Code Input -->
            <div class="form-group">
                <label for="promotion-code">Mã khuyến mại</label>
                <div class="input-group">
                    <input type="text" 
                           class="form-control" 
                           id="promotion-code" 
                           placeholder="Nhập mã khuyến mại" 
                           style="text-transform: uppercase;">
                    <div class="input-group-append">
                        <button type="button" 
                                class="btn btn-primary" 
                                id="apply-promotion-btn">
                            <i class="fas fa-check"></i> Áp dụng
                        </button>
                    </div>
                </div>
            </div>

            <!-- Show Available Promotions -->
            <div class="text-center">
                <button type="button" 
                        class="btn btn-link btn-sm" 
                        id="show-promotions-btn">
                    <i class="fas fa-list"></i> Xem khuyến mại có thể sử dụng
                </button>
            </div>

            <!-- Hidden inputs for form submission -->
            <input type="hidden" id="promotion_id" name="promotion_id" value="">
            <input type="hidden" id="promotion_code" name="promotion_code" value="">
            <input type="hidden" id="discount_amount" name="discount_amount" value="0">
            <input type="hidden" id="final_total" name="final_total" value="">
        </div>
    </div>

    <!-- Order Summary with Promotion -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-receipt"></i> Tóm tắt đơn hàng
            </h5>
        </div>
        <div class="card-body">
            <div class="order-summary">
                <div class="d-flex justify-content-between mb-2">
                    <span>Tạm tính:</span>
                    <span id="subtotal-amount">{{ number_format($subtotal ?? 0) }}đ</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2 text-success" 
                     id="discount-row" style="display: none;">
                    <span>Giảm giá:</span>
                    <span id="discount-amount">0đ</span>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between mb-0">
                    <strong>Tổng cộng:</strong>
                    <strong class="text-primary" id="total-amount">
                        {{ number_format($subtotal ?? 0) }}đ
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Promotion JavaScript -->
<script>
$(document).ready(function() {
    // Cập nhật thông tin đơn hàng cho promotion manager
    if (typeof promotionManager !== 'undefined') {
        const orderValue = {{ $subtotal ?? 0 }};
        const products = @json($products ?? []);
        
        promotionManager.updateOrderInfo(orderValue, products);
    }

    // Lắng nghe event khi áp dụng/xóa khuyến mại
    $(document).on('promotion:applied', function(event, promotion) {
        $('#discount-row').show();
        updatePromotionHiddenInputs(promotion);
    });

    $(document).on('promotion:removed', function() {
        $('#discount-row').hide();
        updatePromotionHiddenInputs(null);
    });

    function updatePromotionHiddenInputs(promotion) {
        if (promotion) {
            $('#promotion_id').val(promotion.id);
            $('#promotion_code').val(promotion.code);
            $('#discount_amount').val(promotion.discount_amount);
        } else {
            $('#promotion_id').val('');
            $('#promotion_code').val('');
            $('#discount_amount').val('0');
        }
    }
});
</script>

<style>
.promotion-section .card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.promotion-applied {
    border-left: 4px solid #28a745;
}

.promotion-item:hover {
    background-color: #f8f9fa;
    border-color: #007bff !important;
}

.promotion-alert {
    margin-bottom: 1rem;
}

#promotion-code {
    text-transform: uppercase;
}

.order-summary {
    font-size: 1.1em;
}

.text-success {
    color: #28a745 !important;
}

#discount-row {
    font-weight: 500;
}
</style>
