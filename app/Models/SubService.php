<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    use HasFactory;

    protected $table = 'sub_services';

    protected $fillable = [
        'service_id',
        'name',
        'price',
        'status',
    ];


    public function service()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    }

    public function repairOrderService()
    {
        return $this->belongsTo(RepairOrderService::class, 'service_id', 'id');
    }



}
