<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use App\Models\ProductSupplier;
use App\Models\ProductVariant;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class EposController extends Controller
{
    public function create(Request $product)
    {
        $p = new Product();
        $p->id = $product->ProductID;
        $p->name = $product->Name;
        $p->code = $product->Barcode;
        $p->slug = Product::createSlug($product->Name);
        $p->description = $product->Description;
        $p->cost = $product->CostPrice;
        $p->price = $product->SalePrice;
        $p->out_price = $product->EatOutPrice;
        $p->category_id = $product->CategoryID;
        if (
            !Stock::where('product_id', $product->ProductID )
                ->where('warehouse_id', 28491)
                ->first()
        ) {
            Stock::create([
                'product_id' => $product->ProductID,
                'warehouse_id' => 28491,
                'rack_number' => 1,
                'quantity' => 5,
                'sold' => 0,
                'returned' => 0,
                'alerts' => 0,
            ]);
        }
        $p->sku = $product->Sku;
        $p->image = $product->Image ?? 'no-image.png';

        $p->unit_id = 1;
        $p->unit_sale_id = 1;
        $p->unit_purchase_id = 1;
        $p->stock_alert = 0;
        $p->save();

        $s = new ProductSupplier();
        $s->supplier_id = $product->SupplierID;
        $s->product_id = $product->ProductID;
        $s->save();

        $v = new ProductVariant();
        $v->product_id = $product->ProductID;
        $v->name = $product->Name;
        $v->save();

        return 1;
    }

    public function sell(Request $request)
    {
        Stock::where('product_id', $request->ProductID)
            ->where('warehouse_id', 28491)
            ->update([
                'quantity' => DB::raw('quantity - ' . $request->quantity),
            ]
        );

        Sale::create([
            "date" => \Carbon\Carbon::now()->toDateString(),
            "product_id" => $request->ProductID,
            "warehouse_id" => 28491,
            "paid_amount" => $request->SalePrice,
            "payment_statut" => $request->SalePrice,
            "statut" => $request->SalePrice,
            "tax_rate" => $request->total_tax,
            "GrandTotal" => $request->total,
        ]);

        return 1;
    }
}
