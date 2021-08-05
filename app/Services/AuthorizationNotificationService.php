<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthorizationNotificationService
{
    public function isAuthorized(): bool
    {
        $status = Http::get('http://o4d9z.mocklab.io/notify')->status();
        
       
        return $status === 200 ? true : false;
    }
}