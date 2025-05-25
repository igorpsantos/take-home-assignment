<?php

/**
 * This method is used to show a var_dump with die if you need debug some variables on codebase flow
 */
function dump(...$args)
{
    echo "<pre>";
    foreach ($args as $arg) {
        var_dump($arg);
    }
    echo "</pre>";
    die();
}

/**
 * This a new version of dump with a pretty dump and json response
 * This method is used to show a var_dump with die if you need debug some variables on codebase flow
 */

function pretty_dump(...$args)
{
    header('Content-Type: application/json');
    echo json_encode($args, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    die();
}

/**
 * This method is used to return a http response on request
 */
function response(int $http_code, string $content_type, mixed $response)
{
    http_response_code($http_code);
    header($content_type);
    echo $content_type == "Content-Type: text/plain" ? $response : json_encode($response);
}