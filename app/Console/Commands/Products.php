<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductSupplier;
use App\Models\ProductVariant;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Products extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        for($page = 1; $page <= 20; $page++) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.eposnowhq.com/api/V1/product?page='.$page,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer U1RMVUFDSEZOVzRNRFVEQ0pXQU5IV0JSWllWMU0xUTc6Q1Y3STFVSzhJUU5MNEY4RDZRSDdJTEZCNzZLUktBVDI=',
                    'Cookie: AWSALB=zgnZYZn4s38+4WwGCCQx61Xt3ymje+X5Qy42uwJOd/ExhqV695GkDG2hRNylaOFUBF5pcoz0c2nlzazOIVNwRxhA+w1qnfHPMbBoZGWpB7+HSJgZEeocsrOf/VNsV2RdJFnjqXZiD1zAlqdOdLvXcOfGUrZEQCMPW1MNK/p3T7awdB+/zrO3RVZQ1eLZgg==; AWSALBCORS=zgnZYZn4s38+4WwGCCQx61Xt3ymje+X5Qy42uwJOd/ExhqV695GkDG2hRNylaOFUBF5pcoz0c2nlzazOIVNwRxhA+w1qnfHPMbBoZGWpB7+HSJgZEeocsrOf/VNsV2RdJFnjqXZiD1zAlqdOdLvXcOfGUrZEQCMPW1MNK/p3T7awdB+/zrO3RVZQ1eLZgg=='
                ),
            ));

            $products = curl_exec($curl);
            curl_close($curl);
            $products = json_decode($products, true);

            try {
                foreach ($products as $product){
                    $p = new Product();
                    $p->id = $product['ProductID'];
                    $p->code = $product['Barcode'];
                    $p->name = $product['Name'];
                    $p->slug = Product::createSlug($product['Name']);
                    $p->description = $product['Description'];
                    $p->cost = $product['CostPrice'];
                    $p->price = $product['SalePrice'];
                    $p->out_price = $product['EatOutPrice'];
                    $p->category_id = $product['CategoryID'];
                    $p->Type_barcode = $product['Barcode'];
                    $p->tax_rate_id = $product['TaxRateID'];
                    $p->eat_out_tax_rate_id = $product['EatOutTaxRateID'];
                    $p->brand_id = $product['BrandID'];
                    $p->popup_note_id = $product['PopupNoteID'];
                    $p->unit_of_sale = $product['UnitOfSale'];
                    $p->volume_of_sale = $product['VolumeOfSale'];
                    $p->multi_choice_id = $product['MultiChoiceID'];
                    $p->colour_id = $product['ColourID'];
                    $p->size = $product['Size'];
                    $p->sku = $product['Sku'];
                    $p->image = $product['image'] ?? 'no-image.png';
                    $p->sell_on_web = $product['SellOnWeb'];
                    $p->order_code = $product['OrderCode'] ?? true;
                    $p->button_colour_id = $product['ButtonColourID'];
                    $p->sort_position = $product['SortPosition'];
                    $p->magento_attribute_set_id = $product['MagentoAttributeSetID'];
                    $p->r_r_price = $product['RRPrice'];
                    $p->cost_price_tax_rate_id = $product['CostPriceTaxRateID'];
                    $p->product_type = $product['ProductType'];

                    $p->unit_id = 1;
                    $p->unit_sale_id = 1;
                    $p->unit_purchase_id = 1;
                    $p->stock_alert = 0;

                    $p->tare_weight = $product['TareWeight'];
                    $p->article_code = $product['ArticleCode'];
                    $p->save();

                    $s = new ProductSupplier();
                    $s->supplier_id = $product['SupplierID'];
                    $s->product_id = $product['ProductID'];
                    $s->save();

                    $v = new ProductVariant();
//                    $v->id = $product['VariantGroupID'];
                    $v->product_id = $product['ProductID'];
                    $v->name = $product['Name'];
                    $v->save();

                }
            } catch (Illuminate\Database\QueryException $e) {

            }
        }

        return 1;
    }


}








