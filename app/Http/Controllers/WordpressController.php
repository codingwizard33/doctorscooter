<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSupplier;
use App\Models\ProductVariant;
use Illuminate\Database\QueryException;
use App\Models\Category;
use App\Models\Sale;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WordpressController extends Controller
{
    public function getFromSite()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://www.doctorscooter.co.uk/wp-json/wc/v3/products?per_page=100&page=8&oauth_consumer_key=ck_7d343a1c14f2619c8fbd7f97b97588099dd02591&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1678438849&oauth_nonce=MFyKWwx4Dh6&oauth_version=1.0&oauth_signature=ejxnoQ2OW01oBujr2odQ6TYxNfc%3D',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        $products = curl_exec($curl);

        curl_close($curl);
        $products = json_decode($products, true);


        foreach ($products as $product) {
            if (Product::where('slug', Product::createSlug($product['name']))->count() > 0) {
                continue;
            }
            $p = new Product();
            $p->id = $product['id'];
            // $p->code = $product['Barcode'];
            $p->name = $product['name'];
            $p->slug = Product::createSlug($product['name']);
            $p->description = $product['description'];
            $p->cost = $product['price'];
            $p->price = $product['price'];
            $p->out_price = $product['price'];
            $p->category_id = Category::where('name', $product['categories'][0]['name'])->count() > 0 ? Category::where('name', $product['categories'][0]['name'])->first()->id : null;
            if (!Stock::where('product_id', $product['id'])->where('warehouse_id', 28491)->first()) {
                Stock::create([
                    'product_id' => $product['id'],
                    'warehouse_id' => 28491,
                    'rack_number' => 1,
                    'quantity' => 5,
                    'sold' => 0,
                    'returned' => 0,
                    'alerts' => 0
                ]);
            }
            // $p->Type_barcode = $product['Barcode'];
            // $p->tax_rate_id = $product['TaxRateID'];
            // $p->eat_out_tax_rate_id = $product['EatOutTaxRateID'];
            // $p->brand_id = $product['BrandID'];
            // $p->popup_note_id = $product['PopupNoteID'];
            // $p->unit_of_sale = $product['UnitOfSale'];
            // $p->volume_of_sale = $product['VolumeOfSale'];
            // $p->multi_choice_id = $product['MultiChoiceID'];
            // $p->colour_id = $product['ColourID'];
            // $p->size = $product['Size'];
            $p->sku = $product['sku'];
            $p->image = $product['image'] ?? 'no-image.png';
            // $p->sell_on_web = $product['SellOnWeb'];
            // $p->order_code = $product['OrderCode'] ?? true;
            // $p->button_colour_id = $product['ButtonColourID'];
            // $p->sort_position = $product['SortPosition'];
            // $p->magento_attribute_set_id = $product['MagentoAttributeSetID'];
            // $p->r_r_price = $product['RRPrice'];
            // $p->cost_price_tax_rate_id = $product['CostPriceTaxRateID'];
            // $p->product_type = $product['type'];

            $p->unit_id = 1;
            $p->unit_sale_id = 1;
            $p->unit_purchase_id = 1;
            $p->stock_alert = 0;

            // $p->tare_weight = $product['TareWeight'];
            // $p->article_code = $product['ArticleCode'];
            $p->save();

            $s = new ProductSupplier();
            $s->supplier_id = $product['parent_id'];
            $s->product_id = $product['id'];
            $s->save();

            $v = new ProductVariant();
            //                    $v->id = $product['VariantGroupID'];
            $v->product_id = $product['id'];
            $v->name = $product['name'];
            $v->save();
        }

        return 1;
    }

    public function handle(Request $request)
    {
        $string = json_encode($request->line_items);
        $json = substr($string, 1, strlen($string) - 2);
        $order = json_decode($json);
        Stock::where('product_id', $order->product_id)
            ->where('warehouse_id', 28491)
            ->update([
                'quantity' => DB::raw('quantity - ' . $order->quantity),
            ]
        );

        Sale::create([
            "date" => \Carbon\Carbon::now()->toDateString(),
            "product_id" => $order->product_id,
            "warehouse_id" => 28491,
            "paid_amount" => $order->price,
            "payment_statut" => $order->price,
            "statut" => $order->price,
            "tax_rate" => $order->total_tax,
            "GrandTotal" => $order->total,
        ]);

        return 1;
    }
}
