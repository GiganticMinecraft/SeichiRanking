<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TwitterIdCheck implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {


        $url = env('APP_URL') . '/api/checkTwitterId/' . $value;

        Log::debug('$url -> '.print_r($url, 1));

        $client = new Client(); //GuzzleHttp\Client
        $response = $client->request('GET',  $url);
        $response_body = json_decode($response->getBody()->getContents(), true);

//        Log::debug('$response_body -> '.print_r($response_body, 1));

        return !empty($response_body);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '入力されたTwitter IDは存在しません。';
    }
}
