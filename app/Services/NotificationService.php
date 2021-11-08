<?php
namespace App\Services;

use App\Jobs\SmsJob;
use App\Jobs\EmailJob;
use App\Interfaces\Services\NotificationServiceInterface;

class NotificationService implements NotificationServiceInterface
{
    public function send($payeeEmail, $payeePhoneNumber, $value, $payerName)
    {
        dispatch(new EmailJob($payeeEmail, $value, $payerName))->onQueue('email');
        dispatch(new SmsJob($payeePhoneNumber, $value, $payerName))->onQueue('sms');
    }
}
