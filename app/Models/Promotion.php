<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promotion extends Model
{
    protected $fillable = [
        'title',
        'code',
        'description',
        'start_date',
        'end_date',
        'discount_type',
        'discount_value',
        'applies_to',
        'usage_limit',
        'used_count',
        'min_order_value',
        'max_discount_amount',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'max_discount_amount' => 'decimal:2'
    ];

    // Quan hệ với sản phẩm
    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_products', 'promotion_id', 'product_id');
    }

    // Quan hệ với danh mục
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'promotion_categories', 'promotion_id', 'category_id');
    }

    // Quan hệ với lịch sử sử dụng
    public function usages()
    {
        return $this->hasMany(PromotionUsage::class);
    }

    // Quan hệ với đơn hàng
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Scope: khuyến mại đang hoạt động
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: khuyến mại còn hiệu lực
    public function scopeValid($query)
    {
        return $query->where('start_date', '<=', Carbon::now())
                    ->where('end_date', '>=', Carbon::now());
    }

    // Scope: khuyến mại có thể sử dụng
    public function scopeUsable($query)
    {
        return $query->active()->valid();
    }

    // Kiểm tra khuyến mại có thể sử dụng không
    public function isUsable()
    {
        // Kiểm tra trạng thái active
        if (!$this->is_active) {
            return false;
        }

        // Kiểm tra thời gian
        $now = Carbon::now();
        if ($this->start_date > $now || $this->end_date < $now) {
            return false;
        }

        // Kiểm tra giới hạn sử dụng
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    // Kiểm tra có thể áp dụng cho đơn hàng không
    public function canApplyToOrder($orderValue, $products = [])
    {
        if (!$this->isUsable()) {
            return false;
        }

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($this->min_order_value && $orderValue < $this->min_order_value) {
            return false;
        }

        // Kiểm tra sản phẩm áp dụng
        if ($this->applies_to === 'specific_products' && !empty($products)) {
            $applicableProducts = $this->products()->pluck('id')->toArray();
            $hasApplicableProduct = false;
            
            foreach ($products as $productId) {
                if (in_array($productId, $applicableProducts)) {
                    $hasApplicableProduct = true;
                    break;
                }
            }
            
            if (!$hasApplicableProduct) {
                return false;
            }
        }

        return true;
    }

    // Tính toán số tiền giảm giá
    public function calculateDiscount($orderValue, $products = [])
    {
        if (!$this->canApplyToOrder($orderValue, $products)) {
            return 0;
        }

        $discount = 0;

        if ($this->discount_type === 'percentage') {
            $discount = ($orderValue * $this->discount_value) / 100;
        } elseif ($this->discount_type === 'fixed') {
            $discount = $this->discount_value;
        }

        // Áp dụng giới hạn số tiền giảm tối đa
        if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
            $discount = $this->max_discount_amount;
        }

        // Đảm bảo giảm giá không vượt quá giá trị đơn hàng
        if ($discount > $orderValue) {
            $discount = $orderValue;
        }

        return $discount;
    }

    // Tăng số lần sử dụng
    public function incrementUsage()
    {
        $this->increment('used_count');
    }

    // Tìm khuyến mại theo mã
    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }

    // Lấy danh sách khuyến mại có thể sử dụng
    public static function getUsablePromotions()
    {
        return static::usable()->get();
    }
}
