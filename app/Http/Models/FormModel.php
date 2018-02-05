<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use MinecraftJP;
use Session;
use Log;

class FormModel extends Model
{
    /**
     * JMSログイン情報を取得する
     * @param null $template_nm
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function get_jms_user_info($template_nm = null)
    {
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
