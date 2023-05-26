<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleOrder extends Model
{
    use Filterable;

    protected $fillable = [
        'uuid',
        'cart_total_cost',
        'cart_total_items',
        'cart_total_price',
        'cart_total_profit',
        'tax',
        'tax_amount',
        'shipping',
        'discount',
        'payable_after_all',
        'profit_after_all',
        'recepient_amount',
        'change_amount',
        'note',
        'tracking',
        'id',
        'items',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'items' => 'json',
        'tax' => 'json',
    ];

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
     * Get the products for the sale order
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
     *
     * @return HasMany
     */
    public function saleOrderProducts(): HasMany
    {
        return $this->hasMany(SaleOrderProduct::class, 'sale_order_id');
    }
}
