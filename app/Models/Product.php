<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductAttribute;
class Product extends Model
{
    protected $fillable = [
        'name',
        'catalog_id',
        'content',
        'price',
        'discount_price',
        'image_link',
        'viewer',
        'buyed',
        'rate_total',
        'rate_count',
        'quantity',
    ];

    // Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'catalog_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    // Quan hệ với ProductReview
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    // Quan hệ với reviews đã duyệt
    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    // Tính điểm trung bình
    public function getAverageRatingAttribute()
    {
        if ($this->rate_count > 0) {
            return round($this->rate_total / $this->rate_count, 1);
        }
        return 0;
    }

    // Lấy số sao đầy đủ
    public function getFullStarsAttribute()
    {
        return floor($this->average_rating);
    }

    // Kiểm tra có sao nửa không
    public function getHasHalfStarAttribute()
    {
        return ($this->average_rating - $this->full_stars) >= 0.5;
    }

    // Lấy số sao trống
    public function getEmptyStarsAttribute()
    {
        $used = $this->full_stars + ($this->has_half_star ? 1 : 0);
        return 5 - $used;
    }

    // Tính phần trăm cho mỗi rating
    public function getRatingPercentagesAttribute()
    {
        $total = $this->rate_count;
        if ($total == 0) {
            return [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        }

        $percentages = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $this->reviews()->where('rating', $i)->count();
            $percentages[$i] = round(($count / $total) * 100, 1);
        }
        
        return $percentages;
    }
}