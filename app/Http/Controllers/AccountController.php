<?php

namespace App\Http\Controllers;
use App\Models\AppAccount;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    //
    public static function AccountPasswordUpdate( Request $request ) {
        $req = $request->all();
        // dd($req);
        $passwordUpdate = AppAccount::AppAccountPasswordUpdate( $req );
        if( !$passwordUpdate ) {
            return view('pages/account/password',['errors'=>true]);
        }
        return redirect('dashboard');
    }

    public static function AccountDelete(){
        $delete = AppAccount::AppAccountDelete();
        if( $delete ){
            return redirect('welcome');
        }
    }
}
