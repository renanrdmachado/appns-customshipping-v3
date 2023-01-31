<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class NsShipping extends Model
{
    use HasFactory;

    public static function NsShippingCarrierGet(){

        if (!Auth::check())
            return;

        $data = DB::table('stores')
            ->where('store_id', Auth::user()->store_id)
            ->first();

        $auth_data = json_decode($data->auth_data);

        $url = env('NS_BASEURL') . '/' . $auth_data->user_id . '/shipping_carriers';

        $NsApiGet = Http::withHeaders([
            'Authentication' => 'bearer '.$auth_data->access_token,
            'User-Agent' => 'Frete Fixo (sampisolution.com.br)'
        ])->get($url);

        $find = false;
        if( count($NsApiGet->json())>0 ) {
            $find = array_filter($NsApiGet->json(), function ($v, $k) {
                if( $v['name'] == env("NS_SHIPPINGCARRIER") ) {
                    return $v;
                }
            },ARRAY_FILTER_USE_BOTH );
        }

        if (!$find)
            return false;

        return reset($find);
    }
    public static function NsShippingCarrierCreate(){

        if (!Auth::check())
            return;

        $data = DB::table('stores')
            ->where('store_id', Auth::user()->store_id)
            ->first();

        $auth_data = json_decode($data->auth_data);

        $url = env('NS_BASEURL') . '/' . $auth_data->user_id . '/shipping_carriers';

        $post_data = array(
            'name' => env("NS_SHIPPINGCARRIER"),
            'callback_url' => env("NS_CBCKURL"),
            'types' => 'ship'
        );

        $post = Http::withHeaders([
            'Authentication' => 'bearer '.$auth_data->access_token,
            'User-Agent' => 'Frete Fixo (sampisolution.com.br)'
        ])->post( $url,$post_data);

        return $post;
    }
    public static function NsShippingCarrierOptionsCreate( $carrier_id ){

        if (!Auth::check())
            return;

        $data = DB::table('stores')
            ->where('store_id', Auth::user()->store_id)
            ->first();

        $auth_data = json_decode($data->auth_data);

        $url = env('NS_BASEURL') . '/' . $auth_data->user_id . '/shipping_carriers/'.$carrier_id.'/options/';

        for ($i = 1; $i <= 5; $i++) {
            $post = Http::withHeaders([
                'Authentication' => 'bearer '.$auth_data->access_token,
                'User-Agent' => 'Frete Fixo (sampisolution.com.br)'
            ])->post( $url, array(
                'code'  => 'fretefixo'.$i,
                'name'  => 'Frete Fixo - '.$i
            ) );
        }

        return $post;
    }

    public static function NsShippingCarrierInit() {
        $get = NsShipping::NsShippingCarrierGet();

        if (!$get){
            $create = NsShipping::NsShippingCarrierCreate();
            if (!$create)
                return;
            $createOptions = NsShipping::NsShippingCarrierOptionsCreate( $create['id'] );
            if (!$createOptions)
                return;
            $get = $create->json();
        }

        return $get;
    }
}
