<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Carbon;

class TransferSales extends Controller
{
    public function transfer()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.eposnowhq.com/api/v1/DailySales',
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

        $data = curl_exec($curl);
        $sales = json_decode($data, true);

        foreach ($sales as $sale) {
            Sale::create([
                "date" => Carbon::now()->toDateString(),
                "product_id" => $sale["ProductID"],
                // "name" => $sale["Name"],
                // "description" => $sale["Description"],
                // "barcode" => $sale["Barcode"],
                // "sku" => $sale["Sku"],
                // "order_code" => $sale["OrderCode"],
                // "brand" => $sale["Brand"],
                // "size" => $sale["Size"],
                // "qte_retturn" => $sale["Qty"],
                // "measure_qty" => $sale["MeasuredQty"],
                "paid_amount" => $sale["Value"],
                "payment_statut" => $sale["Value"],
                "statut" => $sale['Value'],
                "discount" => $sale["Discount"],
                "tax_rate" => $sale["ValueIncVAT"],
                // "value_exec_vat" => $sale["ValueExcVAT"],
                "GrandTotal" => $sale["TotCost"],
                // "margin" => $sale["Margin"],
                // "margin_perc" => $sale["MarginPerc"]
            ]);
        }
        
        return 1;
    }
}
