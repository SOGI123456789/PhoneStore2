<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionUsage extends Model
{
    protected $table = 'promotion_usage';

    protected $fillable = [
        'promotion_id',
        'order_id',
        'user_id',
        'discount_amount',
        'used_at'
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'used_at' => 'datetime'
    ];

    // Quan hệ với khuyến mại
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    // Quan hệ với đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ với người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
