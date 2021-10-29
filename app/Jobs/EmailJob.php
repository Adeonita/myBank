<?php

namespace App\Jobs;

use Exception;
use App\Services\AuthorizationNotificationService;

class EmailJob extends Job
{
    private $payeeEmail;
    private $transactionValue;
    private $payerName;

    public function __construct($payeeEmail, $transactionValue, $payerName)
    {
        $this->payeeEmail = $payeeEmail;
        $this->transactionValue = $transactionValue;
        $this->payerName = $payerName;
    }

    public function handle(AuthorizationNotificationService $authorizationNotificationService)
    {
        $isAuthorized = $authorizationNotificationService->isAuthorized();

        if (!$isAuthorized) {
            throw new Exception("Serviço indisponível   ", 400);
        }

        //Simulação de envio de email
        echo "\n
                Email de destino: $this->payeeEmail \n
                Menssagem: Você recebeu um depósito no valor de R$: $this->transactionValue de $this->payerName \n
            ";
    }

    public function failed($exception)
    {
        echo $exception->getMessage();
    }
}
