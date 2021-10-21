<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthorizationNotificationService
{
    private $url;

    public function __construct()
    {
        $this->url = env('AUTH_NOTIFICATION');
    }

    public function isAuthorized(): bool
    {
        $status = Http::get($this->url)->status();
        
       
        return $status === 200 ? true : false;
    }
}