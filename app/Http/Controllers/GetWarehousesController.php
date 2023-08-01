<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class GetWarehousesController extends Controller
{
    public function getWarehouses()
    {
        $warehouses = Warehouse::all();

        return $warehouses;
    }
}
