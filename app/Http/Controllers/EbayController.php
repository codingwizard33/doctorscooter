<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class EbayController extends Controller
{
    public function handle(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        dd($payload);

        // Do something with the webhook payload, such as store it in a database
        // or trigger an email notification.

        return response('Webhook received', 200);
    }
}
