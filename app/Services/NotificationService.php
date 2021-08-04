<?php
namespace App\Services;

use App\Http\Interfaces\NotificationInterface;
use Illuminate\Support\Facades\Http;

class NotificationService implements NotificationInterface
{
    private $client;

    public function __construct(Http $client)
    {
        $this->client = $client;
    }

    private function getMessage($value, $payerName) 
    {
        return "Você recebeu um deposito no valor de R$ $value de $payerName ";
    }

    public function send($email, $phoneNumber, $value, $payerName): string
    {
        $response = $this->client::get('http://o4d9z.mocklab.io/notify');
        
        if ($response->status() !== 200) {
            //TODO: add to queue
        }
        
        return $this->getMessage($value, $payerName);
    }
}
