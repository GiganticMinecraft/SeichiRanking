<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use MinecraftJP;
use Log;
use Session;


class SocialAccountController extends Controller
{
    /**
     * Redirect the user to the minecraft.jp authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        $minecraftjp = new MinecraftJP(array(
            'clientId'     => env('JMS_CLIENT_ID'),
            'clientSecret' => env('JMS_CLIENT_SECRET'),
            'redirectUri'  => env('JMS_CALLBACK')
        ));

        // Get login url for redirect
        $loginUrl = $minecraftjp->getLoginUrl();

        return redirect($loginUrl);
    }

    /**
     * Obtain the user information
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $minecraftjp = new MinecraftJP(array(
                'clientId'     => env('JMS_CLIENT_ID'),
                'clientSecret' => env('JMS_CLIENT_SECRET'),
                'redirectUri'  => env('JMS_CALLBACK')
            ));

            // Get User
            $user = $minecraftjp->getUser();
            Log::debug(print_r($user, 1));

            // Get Access Token
//            $accessToken = $minecraftjp->getAccessToken();
//            Log::debug(print_r($accessToken, 1));

        } catch (\Exception $e) {
            return redirect('/login');
        }

        // 戻り先URLを取得
        $callback_url = Session::get('callback_url');
        if (empty($callback_url)) {
            $callback_url = '/';
        }
        else {
            Session::forget('callback_url');
        }

        return redirect()->to($callback_url);
    }

    public function logout()
    {
        try {
            $minecraftjp = new MinecraftJP(array(
                'clientId'     => env('JMS_CLIENT_ID'),
                'clientSecret' => env('JMS_CLIENT_SECRET'),
                'redirectUri'  => env('JMS_CALLBACK')
            ));

            Log::debug('ログアウト処理');

            $minecraftjp->logout();

            return redirect()->to('/');

        } catch (\Exception $e) {
            return redirect('/login');
        }
    }
}
