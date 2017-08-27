<?php

namespace App\Services;

use Log;
use GuzzleHttp;

class CustomValidator extends \Illuminate\Validation\Validator
{
    const LINE_FEED_EMPTY_LIMIT = 3;

    /**
     * Discord IDに「#数字」が付いているかチェックする
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateDiscordid($attribute, $value, $parameters)
    {
        if (!preg_match('/#\d+$/', $value)) {
            return false;
        }

        return true;
    }

    /**
     * 3回以上の連続した改行があった場合のエラー
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateRepeatlinefeed($attribute, $value, $parameters)
    {
        // 改行コードで配列に分割
        $text = explode("\n", $value);

        $before_text = null;
        $empty_cnt = 1;

        foreach ($text as $item) {
            Log::debug(mb_strlen($item));

            // 改行コードの判定
            if (preg_match('/^(\r\n|\n|\r)$/', $item)) {
                $empty_cnt++;
            }

            if ($empty_cnt === self::LINE_FEED_EMPTY_LIMIT) {
                return false;
            }
        }

        return true;
    }

    /**
     * Twitterの「user id」or「screen name」が存在するかを判定する
     * @param $attribute
     * @param $contact_id
     * @param $parameters
     * @return bool
     */
    public function validateTwitter($attribute, $contact_id, $parameters)
    {
        $client = new GuzzleHttp\Client();
//        $response = $client->get(
//            'https://api.twitter.com/1.1/users/show.json?user_id=corosuke9&screen_name=corosuke9'
//        );

//        $response = $client->request('GET', 'https://api.twitter.com/1.1/users/show.json?user_id=corosuke9&screen_name=corosuke9', [
//            'headers' => [
//                'user_id'     => $contact_id,
//                'screen_name' => $contact_id,
//            ]
//        ]);
//        Log::debug(__FUNCTION__.'$response -> '.print_r($response, 1));

        return true;

    }

    /**
     * 各種フォームの連続投稿防止
     * @param $attribute
     * @param $form_kind
     * @param $parameters
     * @return bool
     */
    public function validateCookie($attribute, $form_kind, $parameters)
    {
        // クッキーが生きて入れば、投稿不可
        if (!empty($_COOKIE[$form_kind])) {
            Log::debug('cookie -> '.print_r($_COOKIE[$form_kind], 1));
            return false;
        }

        return true;
    }
}