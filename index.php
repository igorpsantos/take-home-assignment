<?php

require_once __DIR__ . '/routes/api.php';
require_once __DIR__ . '/helpers/helper.php';
require_once __DIR__ . '/App/Http/Requests/Request.php';

# TODO
# we need separate responsabilities when we we start the incoming request
# Necessary implement an App Class to start life cycle
# Necessary implement a RouteServiceProvider to handle initial logic of routes
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = explode("?", $_SERVER['REQUEST_URI'])[0] ?? '';

/**
 * We need handle the incoming request using $_SERVER
 * First we verify the fail first logic, before process and response to client
 */

if(!isset($allowedApiRoutes[$request_uri])){
    return response(404, 'Content-Type: application/json', ['error' => 'Not Found']);
}

if(isset($allowedApiRoutes[$request_uri]) && (!isset($allowedMethodRoutes[$request_uri]) || !in_array($request_method, $allowedMethodRoutes[$request_uri]))){
    return response(405, 'Content-Type: application/json', ['error' => 'Method Not Allowed']);
}

/**
 * If in the request we has allowed api routes, we can instance controller class and call the method
 */
$controllerClass = explode("@", $allowedApiRoutes[$request_uri])[0] ?? null;
$methodClass = explode("@", $allowedApiRoutes[$request_uri])[1] ?? null;
if(!$controllerClass || !$methodClass){
   return response(404, 'Content-Type: application/json', ['error' => 'Not Found']);
}

# start process of incoming request into controller
require_once __DIR__ . "/App/Http/Controllers/$controllerClass.php";

# capture raw request
$request = new Request();
$request->capture();

# instace new controller for each request
$baseController = new $controllerClass();
$baseController->$methodClass($request);

# end process of incoming request into controller

?>