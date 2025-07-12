<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';

    protected $fillable = [
        'product_id',
        'attribute_key',
        'attribute_value',
    ];

    public $timestamps = false;

    // Quan hệ ngược về Product (nếu cần)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}