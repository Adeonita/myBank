<?php
namespace App\Services;

use App\Http\Interfaces\NotificationInterface;
use App\Jobs\NotificationJob;
use Exception;

class NotificationService implements NotificationInterface
{
    public function send($email, $phoneNumber, $value, $payerName)
    {
        dispatch(new NotificationJob($email, $phoneNumber, $value, $payerName));
    }
}
