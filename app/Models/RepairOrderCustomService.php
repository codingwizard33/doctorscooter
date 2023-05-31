<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairOrderCustomService extends Model
{
    use HasFactory;

    protected $table = 'repair_order_custom_services';

    protected $fillable = [
        'order_id',
        'name',
        'price',
        'status',
    ];

    public static function status()
    {
        return [
            'pending',
            'done',
            'cancelled',
        ];
    }

    public function order()
    {
        return $this->belongsTo(RepairOrder::class);
    }

}
