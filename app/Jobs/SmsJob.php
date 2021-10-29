<?php

namespace App\Jobs;

use Exception;
use App\Services\AuthorizationNotificationService;

class SmsJob extends Job
{
    private $transactionValue;
    private $payeePhoneNumber;
    private $payerName;

    public function __construct($payeePhoneNumber, $transactionValue, $payerName)
    {
        $this->transactionValue = $transactionValue;
        $this->payerName = $payerName;
        $this->payeePhoneNumber = $payeePhoneNumber;
    }

    public function handle(AuthorizationNotificationService $authorizationNotificationService)
    {
        $isAuthorized = $authorizationNotificationService->isAuthorized();

        if (!$isAuthorized) {
            throw new Exception("Serviço indisponível   ", 400);
        }

        //Simulação de envio de sms
        echo "\n
                
                Numero de telefone de destino: $this->payeePhoneNumber \n  
                Menssagem: Você recebeu um depósito no valor de R$: $this->transactionValue de $this->payerName \n
            ";
    }

    public function failed($exception)
    {
        echo $exception->getMessage();
    }
}
