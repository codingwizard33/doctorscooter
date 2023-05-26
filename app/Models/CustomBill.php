<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomBill extends Model
{
    use Filterable;

    protected $fillable = ['uuid', 'tracking', 'name', 'date', 'time', 'charges', 'description', 'tax', 'tax_amount', 'total_amount', 'items', 'by'];

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
        'items' => 'json',
        'tax' => 'json',
    ];
}
