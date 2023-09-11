<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairOrderSubservice extends Model
{
    use HasFactory;

    protected $table = 'repair_order_subservices';

    protected $fillable = [
        'service_table_id',
        'service_id',
        'subservice_id',
        'subservice_name',
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
        return $this->belongsTo(RepairOrderService::class);
    }
}
