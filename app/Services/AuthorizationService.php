<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthorizationService 
{
    private $client;
    private $url = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    public function __construct(Http $client)
    {
        $this->client = $client;
    }

    public function isAuthorized(): bool
    {
        $status = $this->client::get($this->url)->status();
       
        return $status === 200 ? true : false;
    }
}
