<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthorizationService 
{
    private $client;
    private $url;

    public function __construct(Http $client)
    {
        $this->client = $client;
        $this->url = env('AUTH_TRANSACTION');
    }

    public function isAuthorized(): bool
    {
        $status = $this->client::get($this->url)->status();
       
        return $status === 200 ? true : false;
    }
}
