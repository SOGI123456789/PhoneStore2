<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}