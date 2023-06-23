<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'status'
    ];


    public function subService()
    {
        return $this->hasMany(SubService::class,'id','service_id');
    }


}
