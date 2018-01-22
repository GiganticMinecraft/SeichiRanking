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
        $client = new Client(); //GuzzleHttp\Client

        $response = $client->request( 'GET', '/api/checkTwitterId/');
        $response_body = (string)$response->getBody();

        Log::debug('$response_body -> '.print_r($response_body, 1));


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
