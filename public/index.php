<?php
/**
 * Front controller - routing
 */
$baseDir = dirname(__DIR__);
require $baseDir . '/config/app.php';

$url = trim($_GET['url'] ?? 'jobs', '/');
$url = $url === '' ? 'jobs' : $url;
$parts = array_filter(explode('/', $url));

// Route table: method + path pattern => [Controller, action]
$routes = [
    'GET' => [
        'auth/login' => [AuthController::class, 'login'],
        'auth/register' => [AuthController::class, 'register'],
        'auth/logout' => [AuthController::class, 'logout'],
        'jobs' => [JobController::class, 'index'],
        'jobs/show' => [JobController::class, 'show'],
        'applications' => [ApplicationController::class, 'index'],
        'user/profile' => [UserController::class, 'profile'],
        'user/profile/edit' => [UserController::class, 'profileEdit'],
        'hr/jobs' => [HrController::class, 'jobs'],
        'hr/jobs/create' => [HrController::class, 'jobCreate'],
        'hr/jobs/edit' => [HrController::class, 'jobEdit'],
        'hr/jobs/applicants' => [HrController::class, 'jobApplicants'],
        'download/cv' => [DownloadController::class, 'cv'],
    ],
    'POST' => [
        'auth/login' => [AuthController::class, 'login'],
        'auth/register' => [AuthController::class, 'register'],
        'jobs/apply' => [ApplicationController::class, 'apply'],
        'user/profile/edit' => [UserController::class, 'profileEdit'],
        'hr/jobs/create' => [HrController::class, 'jobCreate'],
        'hr/jobs/store' => [HrController::class, 'jobCreate'],
        'hr/jobs/edit' => [HrController::class, 'jobEdit'],
        'hr/jobs/delete' => [HrController::class, 'jobDelete'],
        'hr/applications/update-status' => [HrController::class, 'applicationUpdateStatus'],
    ],
];

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$key = implode('/', $parts);
$routeList = $routes[$method] ?? [];

if (isset($routeList[$key])) {
    [$controllerClass, $action] = $routeList[$key];
    $controller = new $controllerClass();
    $controller->$action();
    exit;
}

// 404
http_response_code(404);
echo '<h1>404 Not Found</h1><p><a href="' . BASE_URL . '/jobs">Ke beranda</a></p>';
