<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\AppStore;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AsaasSubscriptions extends Model
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

    public static function AsaasSubscriptionsCreate( $data ){
        
        if (!$data)
            return false;

        $url = AsaasSubscriptions::AsaasApi()['url'].'/subscriptions';
        $key = AsaasSubscriptions::AsaasApi()['key'];

        $create = Http::withHeaders([
                "Content-Type"=> "application/json",
                "access_token" => $key
            ])->post( $url,$data);
        if (!$create) {
            echo "AsaasSubscriptions::AsaasSubscriptionsCreate()!<br/>";
            return false;
        }
        
        return $create->json();

    }
    public static function AsaasSubscriptionsGet( $customer_id ){

        if (!$customer_id)
            return false;

        $url = AsaasSubscriptions::AsaasApi()['url'].'/subscriptions?customer='.$customer_id;
        $key = AsaasSubscriptions::AsaasApi()['key'];

        $get = Http::withHeaders([
                "Content-Type"=> "application/json",
                "access_token" => $key
            ])->get( $url);

        if (!$get) {
            echo "AsaasSubscriptions::AsaasSubscriptionsGet()!<br/>";
            return false;
        }

        if( $get['totalCount']==0 ) {
            return false;
        }

        return $get->json()['data'][0];
    }
    public static function AsaasSubscriptionsUpdate(){

    }
    public static function AsaasSubscriptionsPaysGet( $subscription_id ){
        $url = AsaasSubscriptions::AsaasApi()['url'].'/subscriptions/'.$subscription_id.'/payments';
        $key = AsaasSubscriptions::AsaasApi()['key'];

        $get = Http::withHeaders([
                "Content-Type"=> "application/json",
                "access_token" => $key
            ])->get( $url);
        if (!$get) {
            echo "AsaasSubscriptionsPaysGet::AsaasSubscriptionsGet()!<br/>";
            return false;
        }

        if( $get['totalCount']==0 ) {
            return false;
        }

        return $get->json();
    }
    public static function AsaasSubscriptionsRefresh($force=false,$store_id) {

        if (Auth::check()) {
            $store = AppStore::AppStoreGet();
        } elseif($store_id) {
            $store = AppStore::AppStoreGet($store_id);
        } else {
            return false;
        }

        if (!$store)
            return;

        $refresh = false;
        if ($force || Carbon::now()->toDateString() >= $store->subscription_nextDate ) {
            $refresh = true;
        }

        if (!$refresh)
            return false;

        if (!$store || !$store->subscription_data)
            return false;

        $subscription_data = json_decode($store->subscription_data);

        $subscriptionsGet = AsaasSubscriptions::AsaasSubscriptionsGet( $subscription_data->subscription->customer );
        if( !$subscriptionsGet ) {
            $SubscriptionsCreateData = array(
                'customer' => $subscription_data->subscription->customer,
                'billingType'   => "undefined",
                'value' => env('CONFIG_MONTHLY'),
                'nextDueDate'  => Carbon::now()->addDays( env('CONFIG_TRIAL') )->toDateString(),
                'description'   => 'APP NS - Frete Fixo',
                'cycle' => "MONTHLY",
            );

            $subscriptionsGet = AsaasSubscriptions::AsaasSubscriptionsCreate( $SubscriptionsCreateData );
        }

        $paymentsGet = AsaasSubscriptions::AsaasSubscriptionsPaysGet( $subscriptionsGet['id'] );

        $storeUpdateData = array(
            'store_id' => $store->store_id,
            'subscription_data' => json_encode(array(
                'subscription' => $subscriptionsGet,
                'payments'  => $paymentsGet['data'][0]
            )),
            'subscription_status' => $paymentsGet['data'][0]['status'],
            'subscription_nextDate' => $paymentsGet['data'][0]['dueDate'],
            'updated_at'=>Carbon::now()->toDateTimeString(),
        );

        $storeUpdate = AppStore::AppStoreUpdate( $storeUpdateData );

        if (!$storeUpdate)
            return false;
        return true;
    }
}
