<?php

namespace App\Console\Commands;

use App\Models\EposSale;
use Illuminate\Console\Command;

class EposSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:EposSales';

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
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.eposnowhq.com/api/V1/DailySales',
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

        $sales = curl_exec($curl);
        curl_close($curl);
        $sales = json_decode($sales, true);

        try {
            foreach ($sales as $sale){
                $s = new EposSale();
                $s->product_id = $sale['ProductID'];
                $s->name = $sale['Name'];
                $s->description = $sale['Description'];
                $s->barcode = $sale['Barcode'];
                $s->sku = $sale['Sku'];
                $s->order_code = $sale['OrderCode'];
                $s->brand = $sale['Brand'];
                $s->size = $sale['Size'];
                $s->qty = $sale['Qty'];
                $s->measured_qty = $sale['MeasuredQty'];
                $s->value = $sale['Value'];
                $s->discount = $sale['Discount'];
                $s->value_inc_vat = $sale['ValueIncVAT'];
                $s->value_exc_vat = $sale['ValueExcVAT'];
                $s->tot_cost = $sale['TotCost'];
                $s->margin = $sale['Margin'];
                $s->margin_perc = $sale['MarginPerc'];
                $s->reference_code = $sale['ReferenceCode'];
                $s->save();
            }
        } catch (Illuminate\Database\QueryException $e) {

        }

        return 1;
    }
}
