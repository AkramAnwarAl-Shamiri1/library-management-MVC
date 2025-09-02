<?php
namespace App\Notifications;

use App\Interfaces\NotificationInterface;
use App\Traits\LoggingTrait;

class EmailNotification implements NotificationInterface {
    use LoggingTrait;

   
    public function send(string $to, string $message): bool {
       
        $this->log("Email sent to {$to}: {$message}");
        return true;
    }
}
