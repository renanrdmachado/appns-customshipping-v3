<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\AsaasSubscriptions;
use App\Models\AppStore;

class AppShipping extends Model
{
    use HasFactory;
    
    public static function AppShippingSave( $inputs ){
        $data = array(
            'store_id'  => Auth::user()->store_id,
            'shipping_data' => json_encode($inputs)
        );
        // dd( $data );

        $upsert = DB::table('shipping')
            ->upsert($data, ['store_id'],['shipping_data']);
        return $upsert;
    }
    public static function AppShippingOptionsUpsert( $data ){
        $upsert = DB::table('shipping')
            ->upsert( ['shipping_data'=>$data,'store_id'=>Auth::user()->store_id],['store_id'],['shipping_data'] );
        return $upsert;
    }
    public static function AppShippingOptionsGetAll(){

    }
    public static function AppShippingOptionsGet( $store_id = false, $zipcode = false ){

        if(!$store_id && Auth::check()) {
            $store_id = Auth::user()->store_id;
        }

        if(!$store_id)
            return false;

        $range = DB::table('shipping')
            ->where('store_id', $store_id)
            ->first('shipping_data');

        if (!$range)
            return false;

        $res = json_decode( $range->shipping_data );

        if ($zipcode) {
            $res = array_filter($res, function ($k) use ($zipcode) {
                if ($k->from <= $zipcode && $k->to >= $zipcode) {
                    return $k;
                }
            });
        }

        return $res;
    }

    public static function AppShippingOptionResponse( $find ) {

        AsaasSubscriptions::AsaasSubscriptionsRefresh( 0, $find["store_id"] );

        $status = AppStore::AppStoreStatusGet($find["store_id"]);

        if ($status != "RECEIVED")
            return;

        $inputs = array(
            'store_id' => $find["store_id"],
            'cep'   => $find["destination"]["postal_code"]
        );

        $res = AppShipping::AppShippingOptionsGet($inputs['store_id'],$inputs['cep']);

        // $range = DB::table('shipping')
        //     ->where('store_id', $inputs['store_id'])
        //     ->first('shipping_data');

        // if (!$range)
        //     return false;

        // $range = json_decode( $range->shipping_data );
        
        // $res = array_filter($range, function ($k) use($inputs) {
        //     if( $k->from <= $inputs['cep'] && $k->to >= $inputs['cep'] ) {
        //         return $k;
        //     }
        // });

        if (!$res)
            return false;

        foreach($res as $key=>$fd) {

            if (!$fd->active)
                return;

            $min = $fd->min_days;
            $max = $fd->max_days;

            
            $min_delivery_date = Carbon::now()->addDays($min)->toIso8601String();
            $max_delivery_date = Carbon::now()->addDays($max)->toIso8601String();

            $fd->price = str_replace(",", ".", $fd->price);

            //var_dump($data);

            $newkey = $key + 1;
            $rates["rates"][] = array(
                "name"=> $fd->name,
                "code"=> 'fretefixo'.$newkey,
                "price"=> floatval(number_format($fd->price,2,".","") ),
                // "price"=> $fd->price,
                "price_merchant"=> 0,
                "currency"=> "BRL",
                "type"=> "ship",
                "min_delivery_date"=> $min_delivery_date,
                "max_delivery_date"=> $max_delivery_date,
                "reference"=> Str::slug($fd->name,'-')
            );
            $newkey=false;
            
        }
    
        return $rates;

        // return $res;
    }
    
}
