<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use REST;

class enviame extends Controller
{
    public function create_delivery(Request $request)
    {    
         $data = [
            "shipping_order" => array(
                "order_number" => $request->order_number,
                "order_price" => $request->order_price,
                "content_description" => $request->content_description,
                "n_packages" => $request->n_packages,
                "weight" => $request->weight
            ),
            "shipping_origin"=> array(
                "company" => array(
                    "company_code" => env('COMPANY_ENVIAME')
                ),
                "pick_up_address" => array(
                   "warehouse_address" => array(
                        "warehouse_code"=> "wh01"
                   )
                )
            ),
            "shipping_address" => array(
                "customer" => array(
                    "name"=> $request->name,
                    "phone"=> $request->phone,
                    "email"=> $request->email
                ),
                "delivery_address" => array(
                    "home_address" => array(
                        "full_address"=> $request->full_address,
                        "place"=> $request->comuna,
                        "information"=> $request->information
                    )
                )
            ),
            "shipping_carrier" => array(
                "carrier_code" => "CCH"
            )
        ]; 
        $data = json_encode($data);
        $result = REST::apiRestEnviamePost('createDelivery', $data);
        return $result;
    }

    public function track_delivery($tracking){
        $data = [
 //           "tracking_number" => 59598,
            "tracking_number" => $tracking,
            "full_tracking" => true
        ]; 
        $result = REST::apiRestEnviameGet('trackDelivery', $data);
        return $result;
    }

}
