<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code', 'Type_barcode', 'slug', 'name', 'description', 'cost', 'price',
        'out_price', 'category_id', 'brand_id', 'popup_note_id', 'unit_id',
        'unit_sale_id', 'unit_of_sale', 'volume_of_sale', 'multi_choice_id',
        'colour_id', 'button_colour_id', 'sort_position', 'magento_attribute_set_id',
        'r_r_price', 'cost_price_tax_rate_id', 'product_type', 'tare_weight',
        'article_code', 'unit_purchase_id', 'tax_rate_id', "eat_out_tax_rate_id",
        'stock_alert', 'sub_category_id', 'is_variant', 'is_imei', 'not_selling', 'tax_method',
        'image', 'is_active', 'note', 'size', 'sku', 'sell_on_web', 'sell_on_till',
        'order_code',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'sub_category_id' => 'integer',
        'unit_id' => 'integer',
        'unit_sale_id' => 'integer',
        'unit_purchase_id' => 'integer',
        'is_variant' => 'integer',
        'is_imei' => 'integer',
        'brand_id' => 'integer',
        'is_active' => 'integer',
        'cost' => 'double',
        'price' => 'double',
        'stock_alert' => 'double',
        'TaxNet' => 'double',
    ];

    public static function createSlug($title){
        if (Product::whereSlug($slug = Str::slug($title))->exists()) {
            $max = Product::where('name', $title)->count();

            return "{$slug}-".($max + 1);
        }

        return $slug;
    }

    public function ProductVariant()
    {
        return $this->belongsTo('App\Models\ProductVariant');
    }

    public function PurchaseDetail()
    {
        return $this->belongsTo('App\Models\PurchaseDetail');
    }

    public function SaleDetail()
    {
        return $this->belongsTo('App\Models\SaleDetail');
    }

    public function QuotationDetail()
    {
        return $this->belongsTo('App\Models\QuotationDetail');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_id');
    }

    public function unitPurchase()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_purchase_id');
    }

    public function unitSale()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_sale_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function stock()
    {
        return $this->hasMany('App\Models\Stock', 'product_id', 'id');
    }

    public function productWarehouse()
    {
        return $this->belongsToMany(Warehouse::class);


    }
}
