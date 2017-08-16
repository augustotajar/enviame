<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class enviame extends Controller
{
    public function create_delivery()
    {    
         $data = [
            "shipping_order" => array(
                "order_number" => $_POST['order_number'],
                "order_price" => $_POST['order_price'],
                "content_description" => $_POST['content_description'],
                "n_packages" => $_POST['n_packages'],
                "weight" => $_POST['weight']
            ),
            "shipping_origin"=> array(
                "company" => array(
                    "company_code" => "samurai"
                ),
                "pick_up_address" => array(
                   "warehouse_address" => array(
                        "warehouse_code"=> "wh01"
                   )
                )
            ),
            "shipping_address" => array(
                "customer" => array(
                    "name"=> $_POST['name'],
                    "phone"=> $_POST['phone'],
                    "email"=> $_POST['email']
                ),
                "delivery_address" => array(
                    "home_address" => array(
                        "full_address"=> $_POST['full_address'],
                        "place"=> $_POST['comuna'],
                        "information"=> $_POST['information']
                    )
                )
            ),
            "shipping_carrier" => array(
                "carrier_code" => "CCH"
            )
        ]; 

        $ch = curl_init('http://sandbox.easypoint.co/api/v1/createDelivery');
    
        $headers = array(
            'api_key: ' . 'eT0d3RWZoKYb40zeXngilLGRbLuc6B',
            'Accept: application/json',
            'Content-Type: application/json'
        );
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if(!$response) {
            return $error;
        }
        else{
            return $response;
        }
    }

    public function track_delivery(){
        $url = 'http://sandbox.easypoint.co/api/v1/trackDelivery';
        $curl = curl_init();
        $data = [
            "company_code" => "samurai",
//            "company_code" => $_POST['company_code'],
            "api_key" => "eT0d3RWZoKYb40zeXngilLGRbLuc6B",
//            "api_key" => $_POST['api_key'],
            "tracking_number" => 59598,
//            "tracking_number" => $_POST['tracking_number'],
            "full_tracking" => true
        ]; 
        $url = sprintf('%s?%s', $url, http_build_query($data));

        // Exchange format - JSON
        $headers = array(
                            'api_key: ' . 'eT0d3RWZoKYb40zeXngilLGRbLuc6B',
        //                    'api_key: ' . $_POST['api_key'],,
                            'Accept: application/json',
                            'Content-Type: application/json',
                        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        return curl_exec($curl);
    }

}
