<?php

namespace App\Services;


use App\Helper\HttpClientRequest;

class Gateway
{
    use HttpClientRequest;
    /**
     * The base uri to consume user service
     * @var string
     */
    public $baseUri;

    public function __construct()
    {
        $this->baseUri = env('GATEWAY_URL');
        if (session()->has('auth')) {
            $this->setHeaders(['Authorization' => 'Bearer '. session()->get('auth')->token]);
        } else {
            $this->setHeaders(['Authorization' => 'Bearer '. \Cache::get('token-app')]);
        }
    }
}
