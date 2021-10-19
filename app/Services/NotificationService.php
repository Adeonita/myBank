<?php
namespace App\Services;

use App\Http\Interfaces\NotificationInterface;
use App\Jobs\NotificationJob;
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
        dispatch(new NotificationJob($email, $phoneNumber, $value, $payerName));
    }
}
