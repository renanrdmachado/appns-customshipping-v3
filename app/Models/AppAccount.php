<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppAccount extends Model
{
    use HasFactory;

    public static function AppAccountSave(){  
    }

    public static function AppAccountUpdate(){
    }

    public static function AppAccountGet( $get=null  ){

        if( isset($get['store_id']) ) {
            $user = DB::table('users')
                ->where('store_id', $get['store_id'])
                ->first();
        } else {
            $user = DB::table('users')
                ->where('id', Auth::user()->id)
                ->first();
        }

        return $user;

        
    }

    public static function AppAccountPasswordUpdate( $data ) {

        if( !isset( $data['password'] ) || !isset($data['password_confirm'] ) ) 
            return false;

        if( $data['password'] != $data['password_confirm'] )
            return false;

        $hash = Hash::make($data['password']);

        $passwordUpdate = DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['password' => $hash] );

        return $passwordUpdate;
    }

    public static function AppAccountSubscriptionStatus() {
        $store_id = Auth::user()->store_id;
        
        if( !$store_id )   
            return;

        $store = DB::table('stores')
            ->where('store_id',$store_id)
            ->orderBy('id', 'desc')
            ->first();
        
        if( !$store )   
            return;

        return $store->subscription_status;
    }

    public static function AppAccountDelete() {

        if( ! Auth::check() )
            return;
        $store_id = Auth::user()->store_id;

        DB::table('shipping')
        ->where('store_id',$store_id)
        ->delete();

        DB::table('stores')
        ->where('store_id',$store_id)
        ->delete();

        DB::table('users')
        ->where('store_id',$store_id)
        ->delete();

        return true;
    }
}
