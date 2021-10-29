<?php
namespace App\Services;

use App\Http\Interfaces\NotificationInterface;
use App\Jobs\NotificationJob;
use App\Jobs\SmsJob;

class NotificationService implements NotificationInterface
{
    public function send($payeeEmail, $payeePhoneNumber, $value, $payerName)
    {
        dispatch(new NotificationJob($payeeEmail, $payeePhoneNumber, $value, $payerName));
        dispatch(new SmsJob($payeePhoneNumber, $value, $payerName))->onQueue('sms');
    }
}
