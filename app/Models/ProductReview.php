<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'rating',
        'review',
        'is_verified',
        'pros',
        'cons',
        'reviewer_name',
        'images',
    ];

    protected $casts = [
        'pros' => 'array',
        'cons' => 'array',
        'images' => 'array',
        'is_verified' => 'boolean',
    ];

    // Quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }



    // Scope cho đánh giá đã xác minh
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Scope theo rating
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Helper method để hiển thị sao
    public function getStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    // Helper method để hiển thị tên người đánh giá
    public function getDisplayNameAttribute()
    {
        if ($this->reviewer_name) {
            return $this->reviewer_name;
        }
        
        if ($this->user) {
            // Ẩn một phần tên để bảo mật
            $name = $this->user->name;
            if (strlen($name) > 3) {
                return substr($name, 0, 2) . str_repeat('*', strlen($name) - 2);
            }
            return $name;
        }
        
        return 'Khách hàng';
    }

    // Helper method để kiểm tra có thể chỉnh sửa không
    public function canEdit($userId)
    {
        return $this->user_id == $userId && $this->created_at->diffInHours(now()) <= 24;
    }
}
