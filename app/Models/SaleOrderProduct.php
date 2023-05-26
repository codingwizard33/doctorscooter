<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleOrderProduct extends Model
{
    protected $fillable = [
        'uuid',
        'product_id',
        'attribute_id',
        'tracking',
        'sale_order_id',
        'image',
        'name',
        'price',
        'cost',
        'qty',
        'sub_total',
        'data',
        'title',
        'serial_number',
        'identity',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ];

    /**
     * Sale order related to product.
     *
     * @return     BelongsTo  The belongs to.
     */
    public function saleOrder(): BelongsTo
    {
        return $this->belongsTo(SaleOrder::class, 'sale_order_id');
    }
}
