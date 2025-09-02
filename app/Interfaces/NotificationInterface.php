<?php
namespace App\Interfaces;

interface NotificationInterface {
   
    public function send(string $to, string $message): bool;
}
