<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class EposController extends Controller
{
    public function create(Request $request)
    {
        Test::create([
            'test' => $request
        ]);

        return 1;
    }
}
