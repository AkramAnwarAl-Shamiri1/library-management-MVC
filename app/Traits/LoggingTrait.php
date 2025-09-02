<?php
namespace App\Traits;

trait LoggingTrait {
    
    
    private function log(string $message): void {
        $logDir = __DIR__ . '/../../logs';
        $file = $logDir . '/app.log';

       
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $time = (new \DateTime())->format('Y-m-d H:i:s');
        file_put_contents($file, "[{$time}] {$message}\n", FILE_APPEND | LOCK_EX);
    }
}
