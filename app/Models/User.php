<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id'; // Sửa lại cho đúng
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'username', 'email', 'password', 'phone','address', 'role_id'
    ];

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'user_id', 'id');
    }
}