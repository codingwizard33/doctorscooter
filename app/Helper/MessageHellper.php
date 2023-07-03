<?php


namespace App\Helper;


trait MessageHellper
{
    public static function MessageUpdateCreate($id)
    {
        if ($id){
            $message = 'Data updated successfully';
        }else{
            $message = 'Data created successfully';
        }
        return $message;
    }

    public static function MessageDelete()
    {
        return 'Data deleted successfully';
    }

    public static function MessageForMail($item)
    {
        $data = [
            'repair_order_create' => 'Your order has been successfully opened',
            'repair_order_update' => 'Your order has been successfully updated',
            'repair_order_changed' => 'Your order has been successfully changed',
            'repair_order_change_status' => 'Your order has been successfully changed status',
            'repair_order_finish' => 'Your order has been successfully finished',
            'repair_order_service_done' => 'message',
        ];
        return $data[$item];
    }

}
