<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class NsStore extends Model
{
    use HasFactory;

    public static function NsStoreGet( $data ){
        if (!$data)
            return false;

        $auth_data = json_decode($data['auth_data']);

        $NsApiGet = Http::withHeaders([
            'Authentication' => 'bearer '.$auth_data->access_token,
            'User-Agent' => 'Frete Fixo (sampisolution.com.br)'
        ])->get(env( 'NS_BASEURL' ).'/'.$auth_data->user_id.'/store');

        if (!$NsApiGet)
            return false;

        return $NsApiGet->json();
        
    }
}
