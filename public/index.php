<?php
declare(strict_types=1);

spl_autoload_register(function($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';
    if (str_starts_with($class, $prefix)) {
        $relative = substr($class, strlen($prefix));
        $path = $baseDir . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($path)) require $path;
    }
});


$uri = trim(str_replace('/library-mvc/public/', '', $_SERVER['REQUEST_URI']), '/');

if ($uri === '') $uri = 'user/index';

$segments = explode('/', $uri);
$controller = $segments[0] ?? 'user';
$action     = $segments[1] ?? 'index';
$params     = array_slice($segments, 2);

$controller = preg_replace('/[^a-zA-Z0-9]/', '', $controller);
$action     = preg_replace('/[^a-zA-Z0-9]/', '', $action);

$controllerClass = "\\App\\Controllers\\" . ucfirst($controller) . "Controller";

if (!class_exists($controllerClass)) {
    http_response_code(404);
    echo "Controller not found: $controllerClass";
    exit;
}

$ctrl = new $controllerClass();

if (!method_exists($ctrl, $action)) {
    http_response_code(404);
    echo "Action not found: $action";
    exit;
}


call_user_func_array([$ctrl, $action], $params);
