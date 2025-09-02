<?php
namespace App\Core;

class Controller {

    protected function view(string $path, array $data = []): void {
       
        extract($data, EXTR_SKIP);

        
        $fullPath = __DIR__ . '/../Views/' . str_replace('/', DIRECTORY_SEPARATOR, $path);

        if (file_exists($fullPath)) {
            require $fullPath;
        } else {
            
            http_response_code(404);
            echo "View not found: {$path}";
        }
    }

   
     
    protected function redirect(string $url): void {
       
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        } else {
            echo "<script>window.location.href='{$url}';</script>";
            exit;
        }
    }
}
