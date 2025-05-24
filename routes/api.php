<?php

# TODO
# implement Route interface instead of using array
$allowedApiRoutes = [
    '/balance' => 'HandleBalanceController@handleBalance',
    '/event' => 'HandleEventController@handleEvent'
];

$allowedMethodRoutes = [
    '/balance' => ['GET'],
    '/event' => ['POST']
];


?>