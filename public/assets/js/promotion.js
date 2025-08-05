// Promotion Module - Xử lý khuyến mại trong giỏ hàng
class PromotionManager {
    constructor() {
        this.currentPromotion = null;
        this.orderValue = 0;
        this.products = [];
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadUsablePromotions();
    }

    bindEvents() {
        // Kiểm tra mã khuyến mại khi người dùng nhập
        $(document).on('click', '#apply-promotion-btn', (e) => {
            e.preventDefault();
            this.checkPromotionCode();
        });

        // Xóa khuyến mại
        $(document).on('click', '#remove-promotion-btn', (e) => {
            e.preventDefault();
            this.removePromotion();
        });

        // Enter key trong input mã khuyến mại
        $(document).on('keypress', '#promotion-code', (e) => {
            if (e.which === 13) {
                e.preventDefault();
                this.checkPromotionCode();
            }
        });

        // Hiển thị danh sách khuyến mại có thể sử dụng
        $(document).on('click', '#show-promotions-btn', (e) => {
            e.preventDefault();
            this.showUsablePromotions();
        });
    }

    // Cập nhật thông tin đơn hàng
    updateOrderInfo(orderValue, products = []) {
        this.orderValue = orderValue;
        this.products = products;
        
        // Tự động kiểm tra lại khuyến mại hiện tại nếu có
        if (this.currentPromotion) {
            this.validateCurrentPromotion();
        }
    }

    // Kiểm tra mã khuyến mại
    async checkPromotionCode() {
        const code = $('#promotion-code').val().trim();
        
        if (!code) {
            this.showMessage('Vui lòng nhập mã khuyến mại', 'error');
            return;
        }

        this.showLoading(true);

        try {
            const response = await fetch('/api/promotions/check-code', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    code: code,
                    order_value: this.orderValue,
                    products: this.products
                })
            });

            const data = await response.json();

            if (data.valid) {
                this.applyPromotion(data.promotion);
                this.showMessage(data.message, 'success');
            } else {
                this.showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Error checking promotion:', error);
            this.showMessage('Có lỗi xảy ra khi kiểm tra mã khuyến mại', 'error');
        } finally {
            this.showLoading(false);
        }
    }

    // Áp dụng khuyến mại
    applyPromotion(promotion) {
        this.currentPromotion = promotion;
        
        // Cập nhật giao diện
        this.updatePromotionDisplay();
        
        // Cập nhật tổng tiền
        this.updateOrderTotal();
        
        // Trigger event để các component khác biết
        $(document).trigger('promotion:applied', [promotion]);
    }

    // Xóa khuyến mại
    removePromotion() {
        this.currentPromotion = null;
        
        // Clear input
        $('#promotion-code').val('');
        
        // Cập nhật giao diện
        this.updatePromotionDisplay();
        
        // Cập nhật tổng tiền
        this.updateOrderTotal();
        
        // Trigger event
        $(document).trigger('promotion:removed');
        
        this.showMessage('Đã xóa mã khuyến mại', 'info');
    }

    // Kiểm tra khuyến mại hiện tại còn hợp lệ không
    async validateCurrentPromotion() {
        if (!this.currentPromotion) return;

        try {
            const response = await fetch('/api/promotions/check-code', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    code: this.currentPromotion.code,
                    order_value: this.orderValue,
                    products: this.products
                })
            });

            const data = await response.json();

            if (!data.valid) {
                this.showMessage(`Mã khuyến mại không còn hợp lệ: ${data.message}`, 'warning');
                this.removePromotion();
            } else {
                // Cập nhật số tiền giảm mới
                this.currentPromotion.discount_amount = data.promotion.discount_amount;
                this.updatePromotionDisplay();
                this.updateOrderTotal();
            }
        } catch (error) {
            console.error('Error validating promotion:', error);
        }
    }

    // Tải danh sách khuyến mại có thể sử dụng
    async loadUsablePromotions() {
        try {
            const response = await fetch('/api/promotions/usable');
            const promotions = await response.json();
            this.usablePromotions = promotions;
        } catch (error) {
            console.error('Error loading promotions:', error);
            this.usablePromotions = [];
        }
    }

    // Hiển thị danh sách khuyến mại
    showUsablePromotions() {
        if (!this.usablePromotions || this.usablePromotions.length === 0) {
            this.showMessage('Hiện tại không có khuyến mại nào khả dụng', 'info');
            return;
        }

        let html = '<div class="promotions-list">';
        html += '<h5 class="mb-3">Khuyến mại có thể sử dụng:</h5>';
        
        this.usablePromotions.forEach(promotion => {
            const discountText = promotion.discount_type === 'percentage' 
                ? `${promotion.discount_value}%` 
                : `${this.formatMoney(promotion.discount_value)}`;
            
            const minOrderText = promotion.min_order_value 
                ? ` (Đơn từ ${this.formatMoney(promotion.min_order_value)})` 
                : '';

            html += `
                <div class="promotion-item border rounded p-3 mb-2" style="cursor: pointer;" 
                     onclick="promotionManager.selectPromotion('${promotion.code}')">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">${promotion.title}</h6>
                            <p class="mb-1 text-muted small">${promotion.description || ''}</p>
                            <span class="badge badge-primary">Giảm ${discountText}${minOrderText}</span>
                        </div>
                        <code class="text-primary">${promotion.code}</code>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';

        // Hiển thị trong modal hoặc dropdown
        this.showPromotionsModal(html);
    }

    // Chọn khuyến mại từ danh sách
    selectPromotion(code) {
        $('#promotion-code').val(code);
        $('#promotions-modal').modal('hide');
        this.checkPromotionCode();
    }

    // Hiển thị modal khuyến mại
    showPromotionsModal(content) {
        const modalHtml = `
            <div class="modal fade" id="promotions-modal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Khuyến mại khả dụng</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ${content}
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal
        $('#promotions-modal').remove();
        
        // Add new modal
        $('body').append(modalHtml);
        $('#promotions-modal').modal('show');
    }

    // Cập nhật hiển thị khuyến mại
    updatePromotionDisplay() {
        const container = $('#promotion-display');
        
        if (this.currentPromotion) {
            const discountText = this.currentPromotion.discount_type === 'percentage' 
                ? `${this.currentPromotion.discount_value}%` 
                : this.formatMoney(this.currentPromotion.discount_value);

            container.html(`
                <div class="promotion-applied alert alert-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-tag"></i> 
                            <strong>${this.currentPromotion.title}</strong>
                            <br>
                            <small>Mã: ${this.currentPromotion.code} - Giảm ${discountText}</small>
                            <br>
                            <span class="text-success">
                                <strong>-${this.formatMoney(this.currentPromotion.discount_amount)}</strong>
                            </span>
                        </div>
                        <button type="button" id="remove-promotion-btn" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `);
        } else {
            container.empty();
        }
    }

    // Cập nhật tổng tiền đơn hàng
    updateOrderTotal() {
        const subtotal = this.orderValue;
        const discount = this.currentPromotion ? this.currentPromotion.discount_amount : 0;
        const total = subtotal - discount;

        // Cập nhật các element hiển thị tổng tiền
        $('#subtotal-amount').text(this.formatMoney(subtotal));
        $('#discount-amount').text(this.formatMoney(discount));
        $('#total-amount').text(this.formatMoney(total));

        // Cập nhật hidden input để gửi form
        $('#promotion_id').val(this.currentPromotion ? this.currentPromotion.id : '');
        $('#promotion_code').val(this.currentPromotion ? this.currentPromotion.code : '');
        $('#discount_amount').val(discount);
        $('#final_total').val(total);
    }

    // Hiển thị loading
    showLoading(show) {
        const btn = $('#apply-promotion-btn');
        if (show) {
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Kiểm tra...');
        } else {
            btn.prop('disabled', false).html('<i class="fas fa-check"></i> Áp dụng');
        }
    }

    // Hiển thị thông báo
    showMessage(message, type = 'info') {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        }[type] || 'alert-info';

        const icon = {
            'success': 'fa-check-circle',
            'error': 'fa-exclamation-circle',
            'warning': 'fa-exclamation-triangle',
            'info': 'fa-info-circle'
        }[type] || 'fa-info-circle';

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show promotion-alert" role="alert">
                <i class="fas ${icon}"></i> ${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        `;

        // Remove existing alerts
        $('.promotion-alert').remove();
        
        // Add new alert
        $('#promotion-messages').html(alertHtml);
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            $('.promotion-alert').fadeOut();
        }, 5000);
    }

    // Format tiền VNĐ
    formatMoney(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);
    }

    // Lấy thông tin khuyến mại hiện tại
    getCurrentPromotion() {
        return this.currentPromotion;
    }

    // Reset khuyến mại
    reset() {
        this.currentPromotion = null;
        this.orderValue = 0;
        this.products = [];
        $('#promotion-code').val('');
        this.updatePromotionDisplay();
    }
}

// Khởi tạo promotion manager khi document ready
let promotionManager;
$(document).ready(function() {
    promotionManager = new PromotionManager();
});

// Export để sử dụng ở nơi khác
window.PromotionManager = PromotionManager;
window.promotionManager = promotionManager;
