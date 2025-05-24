<?php

require_once __DIR__ . 'routes/api.php';


$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

if(!isset($allowedApiRoutes[$request_uri])){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not Found']);
}

if(isset($allowedApiRoutes[$request_uri]) && !isset($allowedMethodRoutes[$request_method])){
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Method Not Allowed']);
}

$apiMethod = $allowedMethodRoutes[$request_method];
$route = $allowedApiRoutes[$request_uri];

$controllerClass = explode("@", $route)[0];
$methodClass = explode("@", $route)[1];

require_once __DIR__ . "controllers/$controllerClass.php";

$baseController = new $controllerClass();
$baseController->{$methodClass};

?>