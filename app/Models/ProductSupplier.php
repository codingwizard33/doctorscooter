<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSupplier extends Model
{
    use HasFactory;

    protected $table = 'product_supplier';

    protected $fillable = [
        'supplier_id', 'product_id'
    ];
}
