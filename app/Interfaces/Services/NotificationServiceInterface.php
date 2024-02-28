<?php
namespace App\Interfaces\Services;

interface NotificationServiceInterface 
{
    public function send(string $email, string $phoneNumber, float $value, string $payerName);
}
