<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RESTfulModel extends Model
{
    public static function apiRestEnviameGet($route, $data)
    {   
        /*
         * URL_ENVIAME=http://sandbox.easypoint.co/api/v1/
         * TOKEN_ENVIAME=eT0d3RWZoKYb40zeXngilLGRbLuc6B
         * $route ejemplo: createDelivery
         */
        $data['company_code'] = env('COMPANY_ENVIAME');
        $route= env('URL_ENVIAME').$route;
        $route = sprintf('%s?%s', $route, http_build_query($data));

        $headers = array(
             'api_key: ' . env('TOKEN_ENVIAME'),
             'Accept: application/json',
             'Content-Type: application/json'
         );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $route);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $response = curl_exec($curl);
        $error = curl_error($curl);

        if(!$response) {
             return $error;
        }else{
             return $response;
        }
    }
    
    public static function apiRestEnviamePost($route, $data)
    {      
        /*
         * URL_ENVIAME=http://sandbox.easypoint.co/api/v1/
         * TOKEN_ENVIAME=eT0d3RWZoKYb40zeXngilLGRbLuc6B
         * $route ejemplo: trackDelivery
         */
        
        $ch = curl_init(env('URL_ENVIAME').$route);
    
        $headers = array(
            'api_key: ' . env('TOKEN_ENVIAME'),
            'Accept: application/json',
            'Content-Type: application/json'
        );
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if(!$response) {
            return $error;
        }
        else{
            return $response;
        }
    }
}
