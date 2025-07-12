<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status'
    ];

    public $timestamps = false; // Nếu không có updated_at

    // Quan hệ với OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Quan hệ với OrderItem (alias)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Quan hệ với User (nếu có đăng nhập)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Các trạng thái đơn hàng
    public static function getStatusOptions()
    {
        return [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'preparing' => 'Đang chuẩn bị',
            'shipping' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy'
        ];
    }

    // Các phương thức thanh toán
    public static function getPaymentMethods()
    {
        return [
            'cod' => 'Thanh toán khi nhận hàng',
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'momo' => 'Ví MoMo',
            'vnpay' => 'VNPay'
        ];
    }

    // Lấy tên trạng thái
    public function getStatusNameAttribute()
    {
        $statuses = self::getStatusOptions();
        return $statuses[$this->status] ?? 'Không xác định';
    }

    // Lấy tên phương thức thanh toán
    public function getPaymentMethodNameAttribute()
    {
        $methods = self::getPaymentMethods();
        return $methods[$this->payment_method] ?? 'Không xác định';
    }
}
