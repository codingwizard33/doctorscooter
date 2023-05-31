<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairOrder extends Model
{
    use HasFactory;

    protected $table = 'repair_orders';

    protected $fillable = [
        'uuid',
        'key',
        'full_name',
        'phone',
        'email',
        'model',
        'price',
        'bar_code',
        'serial_number',
        'information',
        'payment_comment',
        'payment_option',
        'payment_warranty',
        'payment_status',
        'status',

    ];

    public static function status()
    {
        return [
            'pending',
            'waiting_for_parts',
            'in_progress',
            'completed',
            'cancelled',
        ];
    }

    public static function paymentStatus()
    {
        return [
            'paid',
            'not_paid',
            'pending',
            'cancelled',
        ];
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function service()
    {
        return $this->hasMany(RepairOrderService::class, 'order_id', 'id');
    }

    public function customService()
    {
        return $this->hasMany(RepairOrderCustomService::class, 'order_id', 'id');
    }
}
