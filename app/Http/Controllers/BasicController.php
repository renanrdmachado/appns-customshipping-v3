<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NsAuthentication;
use App\Models\NsShipping;
use App\Models\AppAccount;

class BasicController extends Controller
{
    //
    public static function install(){
        if (!isset($_GET) || !isset($_GET['code']) )
            return view( 'pages/errors/installation' );

        $authentication = NsAuthentication::NsAuthentication( $_GET['code'] );

        $shippingcarrier = NsShipping::NsShippingCarrierInit();
        
        if( !$authentication ) 
            return view( 'pages/errors/installation' );

        return redirect('account/password');
        
    }

    public static function dashboard(){
        $store_id = Auth::user()->store_id;
        $subscription = AppAccount::AppAccountSubscriptionStatus();
        if($subscription=="START"){
            $subscription = false;
        }
        return view('dashboard',['store'=>$store_id,'subscription'=>$subscription]);
    }
}
