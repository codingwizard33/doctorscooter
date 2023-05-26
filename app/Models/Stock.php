<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use Filterable;

    protected $fillable = ['tracking', 'uuid', 'product_id', 'product_attribute_id', 'sold', 'min_stock', 'max_stock', 'current_volume', 'quantity', 'warehouse_id', 'alerts', 'cost_price'];

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
     * Product information belongs to stock
     *
     * @return     BelongsTo  The belongs to.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Product attribute information belongs to stock
     *
     * @return     BelongsTo  The belongs to.
     */
    public function productAttribute(): BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    /**
     * Warehouse information that keeping stock
     *
     * @return     BelongsTo  The belongs to.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
