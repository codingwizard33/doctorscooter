<?php

namespace App\Console\Commands;

use App\Models\product_warehouse;
use Illuminate\Console\Command;

class Stock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Stock';

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
                CURLOPT_URL => 'https://api.eposnowhq.com/api/V2/ProductStock/?page='.$page,
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

            $stocks = curl_exec($curl);
            curl_close($curl);
            $stocks = json_decode($stocks, true);

            try {
                foreach ($stocks as $stock){
                    $s = new \App\Models\Stock();
                    $s->id = $stock['StockID'];
                    $s->warehouse_id = $stock['LocationID'];
                    $s->product_id = $stock['ProductID'];
                    $s->quantity = $stock['CurrentStock'];
                    $s->min_stock = $stock['MinStock'];
                    $s->max_stock = $stock['MaxStock'];
                    $s->current_volume = $stock['CurrentVolume'];
                    $s->sold = $stock['OnOrder'];
                    $s->alerts = $stock['Alerts'];
                    $s->cost_price = $stock['CostPrice'];
                    $s->save();

                    $w = new product_warehouse();
                    $w->product_id = $stock['ProductID'];
                    $w->warehouse_id = $stock['LocationID'];
                    $w->qte = $stock['CurrentStock'];
                    $w->save();
                }
            } catch (Illuminate\Database\QueryException $e) {

            }
        }

        return 1;
    }
}
