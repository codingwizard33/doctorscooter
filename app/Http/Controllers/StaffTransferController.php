<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Role;

class StaffTransferController extends Controller
{
    public function retrieveStaffRoles()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.eposnowhq.com/api/v1/AccessRight',
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
        $roles = json_decode($data, true);

        foreach ($roles as $role) {
            Role::create([
               "id" => $role["AccessRightID"],
               "name" => $role["Name"],
               "description" => $role["Description"],
               "till" => $role["Till"],
               "till_admin" => $role["TillAdmin"],
               "back_office" => $role["BackOffice"],
               "reports" => $role["Reports"],
               "refunds" => $role["Refunds"],
               "table_panning" => $role["TablePlanning"],
               "basket_discount" => $role["BasketDiscount"],
               "item_discount" => $role["ItemDiscount"],
               "stock_send" => $role["StockSend"],
               "stock_receive" => $role["StockReceive"],
               "stock_take" => $role["StockTake"],
               "payouts" => $role["Payouts"],
               "disable_service_charge" => $role["DisableServiceCharge"],
               "no_sale" => $role["NoSale"],
               "petty_cash" => $role["PettyCash"],
               "float_adjust" => $role["FloatAdjust"],
               "admin_options" => $role["AdminOptions"],
               "close_till" => $role["CloseTill"],
               "void_line" => $role["VoidLine"],
               "clear" => $role["Clear"],
               "hold" => $role["Hold"],
               "customer_select" => $role["CustomerSelect"],
               "blind_eod" => $role["BlindEod"],
               "set_max_credit_limit" => $role["SetMaxCreditLimit"],
               "item_discount_limit" => $role["ItemDiscountLimit"],
               "item_discount_limit_perc" => $role["ItemDiscountLimitPerc"],
               "basket_discount_limit" => $role["BasketDiscountLimit"],
               "basket_discount_limit_perc" => $role["BasketDiscountLimitPerc"],
               "refund_limit" => $role["RefundLimit"],
               "status" => 1,
               "label" => $role["Name"]
            ]);
        }

        return 1;
    }

    public function retrieveStaffData()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.eposnowhq.com/api/v1/staff',
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

        $staff = json_decode($data, true);

        foreach ($staff as $value) {
            $fullName = explode(' ', $value['Name']);
            $lastName = isset($fullName[1]) ? $fullName[1] : null;
            Employee::create([
                'id' => $value['StaffID'],
                'firstname' => $fullName[0],
                'lastname' => $lastName,
                'hourly_rate' => $value['HourlyRate'],
                'password' => $value['Password'],

            ]);
        }

        return 1;
    }
}
