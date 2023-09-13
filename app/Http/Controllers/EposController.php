<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class EposController extends Controller
{
    public function sell(Request $request)//Test
    {
        $fo = fopen('badrjan.txt', 'w');
        fwrite($fo, 'Test file!!');
        fclose($fo);
    }
}
