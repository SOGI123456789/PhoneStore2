<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $fillable =['name','parent_id',];
    use SoftDeletes;

    // Quan hệ với Product
    public function products()
    {
        return $this->hasMany(Product::class, 'catalog_id');
    }

    // Quan hệ parent-child với chính Category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
