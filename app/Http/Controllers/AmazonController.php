<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AmazonController extends Controller
{
    public function getProductList()
    {
        $access_key_id = 'YOUR_ACCESS_KEY_ID';
        $secret_access_key = 'YOUR_SECRET_ACCESS_KEY';
        $associate_tag = 'YOUR_ASSOCIATE_TAG';
        $endpoint = 'webservices.amazon.com'; // change to your region
        $uri = '/onca/xml';

        $params = [
            'Service' => 'AWSECommerceService',
            'Operation' => 'ItemSearch',
            'AssociateTag' => $associate_tag,
            'SearchIndex' => 'All',
            'Keywords' => 'magazines', // search keywords
            'ResponseGroup' => 'Images,ItemAttributes',
            'ItemPage' => 1,
        ];

        $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
        ksort($params);

        $canonical_query_string = http_build_query($params, '', '&', PHP_QUERY_RFC3986);

        $string_to_sign = "GET\n$endpoint\n$uri\n$canonical_query_string";
        $signature = base64_encode(hash_hmac('sha256', $string_to_sign, $secret_access_key, true));
        $signature = str_replace('%7E', '~', rawurlencode($signature));

        $request_url = "https://$endpoint$uri?$canonical_query_string&Signature=$signature";

        $client = new Client();
        $response = $client->get($request_url);

        return response($response->getBody())->header('Content-Type', 'application/xml');
    }
}
