<?php


namespace App\Helper;


use Twilio\Rest\Client as Client_Twilio;

class Hellper
{
    public static function sendSMS($phone, $message, $serviceName = 'twilio')
    {

//        $url = url('/api/payment_return_purchase_pdf/' . $request->id);
//        $receiverNumber = $payment['PurchaseReturn']['provider']->phone;
//        $message = "Dear" .' '.$payment['PurchaseReturn']['provider']->name." \n We are contacting you in regard to a Payment #".$payment['PurchaseReturn']->Ref.' '.$url.' '. "that has been created on your account. \n We look forward to conducting future business with you.";

        if($serviceName == "twilio"){
            try {

                $account_sid = env("TWILIO_SID");
                $auth_token = env("TWILIO_TOKEN");
                $twilio_number = env("TWILIO_FROM");

                $client = new Client_Twilio($account_sid, $auth_token);
                $client->messages->create($phone, [
                    'from' => $twilio_number,
                    'body' => $message]);

            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }

            //nexmo
        }elseif($serviceName == "nexmo"){
            try {

                $basic  = new \Nexmo\Client\Credentials\Basic(env("NEXMO_KEY"), env("NEXMO_SECRET"));
                $client = new \Nexmo\Client($basic);
                $nexmo_from = env("NEXMO_FROM");

                $message = $client->message()->send([
                    'to' => $phone,
                    'from' => $nexmo_from,
                    'text' => $message
                ]);

            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
        return true;
    }

}
