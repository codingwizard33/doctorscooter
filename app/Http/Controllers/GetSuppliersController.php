<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class GetSuppliersController extends Controller
{
    public function getSuppliers()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.eposnowhq.com/api/v1/Supplier',
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
        curl_close($curl);

        $suppliers = json_decode($data, true);

        foreach ($suppliers as $supplier) {
            Provider::create([
                'id' => $supplier['SupplierID'],
                'name' => $supplier['SupplierName'] . ' ' . $supplier['SupplierDescription'],
                'country' => $supplier['County'],
                'city' => $supplier['Town'],
                'adresse' => $supplier['AddressLine1'],
                'email' => $supplier['EmailAddress'],
                'phone' => $supplier['ContactNumber']
            ]);
        }

        return 1;
    }
}
