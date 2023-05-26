<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomProduct extends Model
{
    use Filterable;

    protected $fillable = ['key', 'uuid', 'image', 'docs', 'full_name', 'email', 'phone', 'address', 'model', 'imei', 'serial_number', 'cost', 'price', 'is_sold', 'sign'];

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
        'is_sold' => 'boolean',
    ];
}
