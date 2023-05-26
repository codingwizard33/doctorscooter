<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductAttribute extends Model
{
    protected $fillable = ['product_id', 'title', 'cost', 'price', 'ws_price', 'serial_number', 'identity', 'sku', 'upc', 'is_serial_based'];

    /**
     * Product information belongs to attribute
     *
     * @return     BelongsTo  The belongs to.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Product stocks
     *
     * @return     HasMany  The has many.
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function getTotalInStock()
    {
        return $this->stocks->sum('quantity');
    }

    public function getTotalSoldStock()
    {
        return $this->stocks->sum('sold');
    }
}
