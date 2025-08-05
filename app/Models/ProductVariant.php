<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'color',
        'ram',
        'rom',
        'price',
        'discount_price',
        'quantity',
        'image_link',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Quan hệ ngược về Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Lấy giá cuối cùng (ưu tiên discount_price nếu có)
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    // Kiểm tra còn hàng
    public function isInStock()
    {
        return $this->quantity > 0;
    }
}
