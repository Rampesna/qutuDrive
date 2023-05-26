<?php

namespace App\Services\ApiAyssoft;

use Illuminate\Support\Facades\Http;

abstract class ApiAyssoftService
{
    protected $baseUrl;
    public $_token;

    public function __construct()
    {
        $this->baseUrl = env('API_AYSSOFT_BASE_URL', 'http://api.ayssoft.com/api/');
    }

    public function Login()
    {
        $endpoint = 'Account/Login';
        $headers = [
            'Content-Type: application/json'
        ];
        $params = [
            'Email' => 'nurullah.alisik',
            'Password' => '123'
        ];
        return $this->callApi($this->baseUrl . $endpoint, 'post', $headers, $params)['response']['accessToken'];
    }

    public function callApi($url, $method, $headers = [], $params = [], $body = [])
    {
        return Http::withHeaders($headers)->$method($url, $params);
    }
}
