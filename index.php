<?php

require_once __DIR__ . '/routes/api.php';
require_once __DIR__ . '/helpers/helper.php';

# Is necessary start session to share data into requests
session_start();

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
require_once __DIR__ . "/controllers/$controllerClass.php";

# TODO
# Necessary implement Request Http Class
$request = [
    'server_info' => $_SERVER,
    'payload' => $request_method == 'GET' ? $_GET : $_POST # if we'll need to work with other methods is necessary to implement a match function to get correctly allowed method
];

$baseController = new $controllerClass();
$baseController->$methodClass($request);

# end process of incoming request into controller

?>