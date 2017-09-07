<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use MinecraftJP;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * サーバーステータス(接続人数)を取得する
     * @return mixed|null
     */
    public function get_server_status()
    {
        $server_status = null;

        if ($json = @file_get_contents(env('SERVER_STATUS_URL'))) {
            $server_status = json_decode($json, true);
//            Log::debug(print_r($server_status, 1));
        }

        return $server_status;
    }

    /**
     * JMSへのログイン認証
     * @return $auth_info
     */
    public function jms_login_auth()
    {
        // JMSへAuth認証
        $auth_info = new MinecraftJP(array(
            'clientId'     => env('JMS_CLIENT_ID'),
            'clientSecret' => env('JMS_CLIENT_SECRET'),
            'redirectUri'  => env('JMS_CALLBACK')
        ));

        // Get Access Token
//            $accessToken = $minecraftjp->getAccessToken();
//            Log::debug('$accessToken ->'.print_r($accessToken, 1));

        return $auth_info;
    }

}
