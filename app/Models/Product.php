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
}