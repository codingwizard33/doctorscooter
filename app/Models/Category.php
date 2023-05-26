<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code', 'name', 'slug', 'image', 'description',
        'parent_id', 'show_on_till', 'wet', 'button_colour_id'
        , 'sort_position', 'reporting_category_id',
        'nominal_code'
    ];

}
