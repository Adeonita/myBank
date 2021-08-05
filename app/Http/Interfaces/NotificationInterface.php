<?php
namespace App\Http\Interfaces;

interface NotificationInterface 
{
    public function send(string $email, string $phoneNumber, float $value, string $payerName);
}
