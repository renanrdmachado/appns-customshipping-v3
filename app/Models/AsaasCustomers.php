<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class AsaasCustomers extends Model
{
    use HasFactory;

    private static function AsaasApi(){
        if( env('ASAAS_MODE')=="production" ){
            return array(
                'url'   => env('ASAAS_BASEURL'),
                'key'   => env('ASAAS_KEY'),
            );
        } else {
            return array(
                'url'   => env('ASAAS_BASEURL_SANDBOX'),
                'key'   => env('ASAAS_KEY_SANDBOX'),
            );
        }
    }
    public static function AsaasCustomerGet( $customer ){

        if( isset( $customer['cpfCnpj']  ) ) {
            $query = "?cpfCnpj=" . $customer['cpfCnpj'];
        } else {
            return false;
        }

        $url = AsaasCustomers::AsaasApi()['url'].'/customers'.$query;
        $key = AsaasCustomers::AsaasApi()['key'];

        $get = Http::withHeaders([
                "Content-Type"=> "application/json",
                "access_token" => $key
            ])->get( $url);
        
        if (!$get) {
            echo "AsaasCustomers::AsaasCustomerGet()!<br/>";
            return false;
        }
        if ($get['totalCount']==0) {
            echo "AsaasCustomers::AsaasCustomerGet()! totalCount<br/>";
            return false;
        }

        return $get->json()['data'][0];
        
    }

    public static function AsaasCustomerCreate( $customer ){
        
        if (!$customer)
            return;

        $url = AsaasCustomers::AsaasApi()['url'].'/customers';
        $key = AsaasCustomers::AsaasApi()['key'];

        $post = Http::withHeaders([
                "Content-Type"=> "application/json",
                "access_token" => $key
            ])->post( $url,$customer);
        
        if (!$post) {
            echo "AsaasCustomers::AsaasCustomerCreate()!<br/>";
            return false;
        }

        if (!isset($post['id'])) {
            echo "AsaasCustomers::AsaasCustomerCreate()! totalCount<br/>";
            return false;
        }

        return $post->json();
    }

    public static function AsaasCustomerSearch(){

    }

    public static function AsaasCustomerUpdate(){

    }
}
