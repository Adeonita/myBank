<?php
namespace App\Services;

use App\Http\Interfaces\NotificationInterface;
use App\Jobs\EmailJob;
use App\Jobs\SmsJob;

class NotificationService implements NotificationInterface
{
    public function send($payeeEmail, $payeePhoneNumber, $value, $payerName)
    {
        dispatch(new EmailJob($payeeEmail, $value, $payerName))->onQueue('email');
        dispatch(new SmsJob($payeePhoneNumber, $value, $payerName))->onQueue('sms');
    }
}
