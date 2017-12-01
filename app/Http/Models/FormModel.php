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
        try {
            // ユーザ情報を取得
            $jms_user_info = $this->jms_login_auth()->getUser();
            Log::debug(__FUNCTION__.' : login user ->'.print_r($jms_user_info, 1));

            return $jms_user_info;
        }
        // 未ログインの場合、例外としてキャッチする
        catch (\Exception $e) {
            // セッションに戻り先URLをセット
            Session::put('callback_url', '/' . $template_nm);

            Log::debug(print_r($e->getMessage(), 1));
            return redirect()->to('/login/jms');
        }
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
