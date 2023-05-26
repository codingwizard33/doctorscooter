<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use Filterable;

    protected $fillable = ['status', 'imei', 'tracking', 'uuid', 'email', 'name', 'phone', 'address', 'issue', 'device_name', 'charges', 'serial_number', 'tax', 'tax_amount', 'due', 'pre_paid', 'total_amount', 'by', 'message', 'profit', 'cost'];

    /**
     * Setting default route key
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'tax' => 'json',
    ];
}
