<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class EposController extends Controller
{

    public function sell(Request $request)//Test
    {
        $fo = fopen('testStock.txt', 'w');
        foreach ($request->all() as $key => $value) {
            fwrite($fo, $key . ': ' . $value . "\n");
        }
        fclose($fo);
    }

    public function epos_update_product_stock(Request $request) //Test
    {
        $fo = fopen('epos_update_product_stock.txt', 'w');
        foreach ($request->all() as $key => $value) {
            fwrite($fo, $key . ': ' . $value . "\n");
        }
        fclose($fo);
    }
    public function epos_create_product_stock_event(Request $request) //Test
    {
        $fo = fopen('epos_create_product_stock_event.txt', 'w');
        foreach ($request->all() as $key => $value) {
            fwrite($fo, $key . ': ' . $value . "\n");
        }
        fclose($fo);
    }
    public function epos_create_purchase_order(Request $request) //Test
    {
        $fo = fopen('epos_create_purchase_order.txt', 'w');
        foreach ($request->all() as $key => $value) {
            fwrite($fo, $key . ': ' . $value . "\n");
        }
        fclose($fo);
    }
    public function epos_update_purchase_order(Request $request) //Test
    {
        $fo = fopen('epos_update_purchase_order.txt', 'w');
        foreach ($request->all() as $key => $value) {
            fwrite($fo, $key . ': ' . $value . "\n");
        }
        fclose($fo);
    }
    public function epos_update_product_in_stock(Request $request) //Test
    {
        $fo = fopen('epos_update_product_in_stock.txt', 'w');
        foreach ($request->all() as $key => $value) {
            fwrite($fo, $key . ': ' . $value . "\n");
        }
        fclose($fo);
    }
    public function epos_create_ordered_transaction(Request $request) //Test
    {
        $fo = fopen('epos_update_product_in_stock.txt', 'w');
        foreach ($request->all() as $key => $value) {
            fwrite($fo, $key . ': ' . $value . "\n");
        }
        fclose($fo);
    }
}

