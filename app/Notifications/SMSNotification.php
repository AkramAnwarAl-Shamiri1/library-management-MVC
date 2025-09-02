<?php
namespace App\Notifications;

use App\Interfaces\NotificationInterface;
use App\Traits\LoggingTrait;

class SMSNotification implements NotificationInterface {
    use LoggingTrait;

   
    public function send(string $to, string $message): bool {
     
        $this->log("SMS sent to {$to}: {$message}");
        return true;
    }
}
