<?php
namespace App\Services;

use App\Http\Interfaces\NotificationInterface;
// use App\Jobs\NotificationJob;
use Exception;
use App\Services\KafkaService;
use App\Services\AuthorizationNotificationService;


class NotificationService implements NotificationInterface
{
    private $authorizationNotificationService;

    public function __construct(AuthorizationNotificationService $authorizationNotificationService)
    {
        $this->authorizationNotificationService = $authorizationNotificationService;
    }
    public function send($email, $phoneNumber, $value, $payerName)
    {
        $isAuthorized = $this->authorizationNotificationService->isAuthorized();
        $queue = new KafkaService($email, $phoneNumber, $value, $payerName);

        if ($isAuthorized) {
            $queue->sendToQueue();
        } else {
            //TODO: criar fila dos erros de autorização
        }
        
        // dispatch(new NotificationJob($email, $phoneNumber, $value, $payerName));
    }
}
