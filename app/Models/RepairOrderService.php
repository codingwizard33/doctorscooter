<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairOrderService extends Model
{
    use HasFactory;

    protected $table = 'repair_order_services';

    protected $fillable = [
        'order_id',
        'service_id',
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
