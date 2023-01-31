<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppAccount;
use App\Models\AppStore;
use App\Models\AsaasCustomers;
use App\Models\AsaasSubscriptions;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
// use App\Models\User;

class SubscriptionsController extends Controller
{
    //
    public static function SubscriptionsPageEditor(){
        $status = AppAccount::AppAccountSubscriptionStatus();
        $userData = AppAccount::AppAccountGet();
        $storeData = AppStore::AppStoreGet();
        
        return view('pages/account/subscriptions', ['status'=>$status,'user'=>$userData,'store'=>$storeData] );
    }

    public static function SubscriptionsPageEditorNew(Request $request) {
        $req = $request->all();
        $customerGet = AsaasCustomers::AsaasCustomerGet( ['cpfCnpj'=>$req['cpfCnpj']] );
        
        if( !$customerGet ) {
            $customerGet = AsaasCustomers::AsaasCustomerCreate( $req );
        }

        $subscriptionsGet = AsaasSubscriptions::AsaasSubscriptionsGet( $customerGet['id'] );

        if( !$subscriptionsGet ) {
            $SubscriptionsCreateData = array(
                'customer' => $customerGet['id'],
                'billingType'   => "undefined",
                'value' => ($req['cycle']=="MONTHLY")?env('CONFIG_MONTHLY'):env('CONFIG_YEARLY'),
                'nextDueDate'  => Carbon::now()->addDays( env('CONFIG_TRIAL') )->toDateString(),
                'description'   => 'APP NS - Frete Fixo',
                'cycle' => $req['cycle'],
            );

            $subscriptionsGet = AsaasSubscriptions::AsaasSubscriptionsCreate( $SubscriptionsCreateData );
        }

        $paymentsGet = AsaasSubscriptions::AsaasSubscriptionsPaysGet( $subscriptionsGet['id'] );

        if( $paymentsGet['totalCount']==0 ) {
            echo "erro Payment";
            return false;
        }

        $storeUpdateData = array(
            'store_id' => Auth::user()->store_id,
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

        return $storeUpdateData;
        // dd($paymentsGet['data'][0]);
        // dd( $subscriptionsGet );
        // CRIOU
        // dd( $get );
    }

    public static function SubscriptionsRefresh(){
        $store = Auth::user()->store_id;
        return AsaasSubscriptions::AsaasSubscriptionsRefresh(true,$store);
    }
}
