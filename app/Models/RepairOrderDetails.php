<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairOrderDetails extends Model
{
    use HasFactory;

    protected $table = 'repair_order_details';

    protected $fillable = [
        'user_id',
        'order_id',
        'text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function repairOrder()
    {
        return $this->belongsTo(RepairOrder::class, 'order_id', 'id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
