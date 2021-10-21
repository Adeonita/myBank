<?php

namespace App\Jobs;

use Exception;
use App\Services\AuthorizationNotificationService;

class NotificationJob extends Job
{
    private $email;
    private $value;
    private $phoneNumber;
    private $payerName;

    public function __construct($email, $phoneNumber, $value, $payerName)
    {
        $this->email = $email;
        $this->value = $value;
        $this->payerName = $payerName;
        $this->phoneNumber = $phoneNumber;
    }

    public function handle(AuthorizationNotificationService $authorizationNotificationService)
    {
        $isAuthorized = $authorizationNotificationService->isAuthorized();

        if (!!$isAuthorized) {
            throw new Exception("Serviço indisponível   ", 400);
        }

        //Simulação de envio de email
        echo "\n
                Email de destino: $this->email \n
                Numero de telefone de destino: $this->phoneNumber \n  
                Menssagem: Você recebeu um deposito no valor de R$: $this->value de $this->payerName \n
            ";
    }

    public function failed($exception)
    {
        echo $exception->getMessage();
    }
}
