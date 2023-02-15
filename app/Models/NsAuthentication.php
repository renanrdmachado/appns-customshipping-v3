<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\AppStore;
use App\Models\NsStore;
use App\Models\AppAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NsAuthentication extends Model
{
    use HasFactory;

    public static function NsAuthentication( $code ){
        $data = [
            "client_id"=> env( 'NS_APPID' ),
            "client_secret"=> env( 'NS_APPSECRET' ),
            "grant_type"=> "authorization_code",
            "code"=> $code
        ];

        $token = Http::post('https://www.nuvemshop.com.br/apps/authorize/token',$data);
        if (!$token) {
            echo "NsAuthentication: Erro no Authorize Token!<br/>";
            return false;
        }
        

        $token = $token->json();

        if (isset($token['error'])) {
            echo "NsAuthentication: Erro no Token!<br/>";
            return false;
        }

        $storeSave = AppStore::AppStoreSave( $token );

        if (!$storeSave){   
            echo "NsAuthentication: Erro no AppStore::AppStoreSave()!<br/>";
            return false;
        }

        $storeGet = NsStore::NsStoreGet( $storeSave );

        if (!$storeGet) {
            echo "NsAuthentication: Erro no NsStore::NsStoreGet()!<br/>";
            return false;
        }

        $accountGet = AppAccount::AppAccountGet( array('store_id' => $storeGet['id'] ) );

        if( !$accountGet ) {
            // echo "NsAuthentication: Erro no AppAccount::AppAccountGet()!<br/>";
            $user = User::create([
                'name' => $storeGet['name']['pt'],
                'email' => $storeGet['email'],
                'password' => Hash::make( rand(0, 99) ),
            ]);
    
            Auth::login($user);
        } else {
            Auth::loginUsingId($accountGet->id);
        }

        $userUpdate = DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['store_id'=>$storeGet['id']]);

        // return true;

        return $storeGet['id'];

    }
}
