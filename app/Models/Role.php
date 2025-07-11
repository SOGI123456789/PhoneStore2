<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}

