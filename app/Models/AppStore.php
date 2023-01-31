<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth;
// use App\Models\NsStore;

class AppStore extends Model
{
    use HasFactory;

    public static function AppStoreSave( $store ){
        // dd( $store );
        $data = [
            'store_id' => $store['user_id'],
            'auth_data'  => json_encode($store)
        ];
        // dd($data);

        $save = DB::table('stores')
            ->upsert($data, ['store_id'],['auth_data']);

        if( !$save ) {
            echo "Erro AppStore save()";
            return false;
        }

        return $data;
    }

    public static function AppStoreUpdate( $data ) {
        // {"access_token":"4580f098bd84d3c196ae054c600b78cfcc16a11c","token_type":"bearer","scope":"read_content,write_content,read_shipping,write_shipping,read_discounts,write_discounts,write_scripts,read_locations,write_locations","user_id":1983889}
        $update = DB::table('stores')
            ->upsert($data, ['store_id']);
            
        if( !$update ) {
            echo "Erro AppStore AppStoreUpdate()";
            return false;
        }

        // dd( $update );
        return $update;

    }

    public static function AppStoreGet($store=false){
        if( $store ) {
            $store_id = $store;
        } else {
            $store_id = Auth::user()->store_id;
        }

        $store = DB::table('stores')
            ->where('store_id', $store_id)
            ->first();

        return $store;

    }

    public static function AppStoreStatusGet($store_id=false){
        if( !$store_id && Auth::check() ) {
            $store_id = Auth::user()->store_id;
        }

        if (!$store_id)
            return false;

        $status = DB::table('stores')
            ->where('store_id', $store_id)
            ->get(['subscription_status'])
            ->first();

        if (!$status)
            return false;

        return $status->subscription_status;
    }
    
}
