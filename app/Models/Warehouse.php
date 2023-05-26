<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $dates = ['deleted_at'];

    protected $fillable = [
       'location_area_id', 'name', 'description', 'address1', 'address2', 'mobile', 'county', 'country', 'city', 'email', 'zip', 'post_code', 'location', 'max_volume',
    ];

    public function assignedUsers()
    {
        return $this->belongsToMany('App\Models\User');
    }

}
