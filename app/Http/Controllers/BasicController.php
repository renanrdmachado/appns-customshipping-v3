<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\NsAuthentication;

class BasicController extends Controller
{
    //
    public static function install(){
        if (!isset($_GET) || !isset($_GET['code']) )
            return view( 'pages/errors/installation' );

        $authentication = NsAuthentication::NsAuthentication( $_GET['code'] );
        
        if( !$authentication ) 
            return view( 'pages/errors/installation' );

        return redirect('account/password');
        
    }
}
