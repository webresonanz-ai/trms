<?php

declare(strict_types=1);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$routes = [
    ['method' => 'POST', 'pattern' => '#^/api/auth/login$#', 'handler' => [\TRMS\Controllers\AuthController::class, 'login']],
    ['method' => 'POST', 'pattern' => '#^/api/auth/register$#', 'handler' => [\TRMS\Controllers\AuthController::class, 'register']],
    ['method' => 'GET', 'pattern' => '#^/api/auth/me$#', 'handler' => [\TRMS\Controllers\AuthController::class, 'me']],

    ['method' => 'GET', 'pattern' => '#^/api/dashboard$#', 'handler' => [\TRMS\Controllers\DashboardController::class, 'index']],
    ['method' => 'GET', 'pattern' => '#^/api/dashboard/stats$#', 'handler' => [\TRMS\Controllers\DashboardController::class, 'stats']],
    ['method' => 'GET', 'pattern' => '#^/api/dashboard/activities$#', 'handler' => [\TRMS\Controllers\DashboardController::class, 'activities']],

    ['method' => 'GET', 'pattern' => '#^/api/events$#', 'handler' => [\TRMS\Controllers\EventController::class, 'index']],
    ['method' => 'GET', 'pattern' => '#^/api/events/upcoming$#', 'handler' => [\TRMS\Controllers\EventController::class, 'upcoming']],
    ['method' => 'GET', 'pattern' => '#^/api/events/month$#', 'handler' => [\TRMS\Controllers\EventController::class, 'byMonth']],
    ['method' => 'GET', 'pattern' => '#^/api/events/(\d+)$#', 'handler' => [\TRMS\Controllers\EventController::class, 'show']],
    ['method' => 'POST', 'pattern' => '#^/api/events$#', 'handler' => [\TRMS\Controllers\EventController::class, 'store']],
    ['method' => 'PUT', 'pattern' => '#^/api/events/(\d+)$#', 'handler' => [\TRMS\Controllers\EventController::class, 'update']],
    ['method' => 'DELETE', 'pattern' => '#^/api/events/(\d+)$#', 'handler' => [\TRMS\Controllers\EventController::class, 'destroy']],

    ['method' => 'GET', 'pattern' => '#^/api/profile$#', 'handler' => [\TRMS\Controllers\UserController::class, 'profile']],
    ['method' => 'PUT', 'pattern' => '#^/api/profile$#', 'handler' => [\TRMS\Controllers\UserController::class, 'updateProfile']],
];

foreach ($routes as $route) {
    if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
        array_shift($matches);
        [$controllerClass, $methodName] = $route['handler'];
        $controller = new $controllerClass();
        call_user_func_array([$controller, $methodName], $matches);
        exit;
    }
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Not Found', 'message' => 'Endpoint not found']);
exit;
