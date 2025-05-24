<?php

# TODO
# implement Route interface instead of using array
$allowedApiRoutes = [
    '/balance' => 'HandleBalanceController@handleBalance',
    '/event' => 'HandleEventController@handleEvent',
    '/reset' => 'ResetSessionController@reset'
];

$allowedMethodRoutes = [
    '/balance' => ['GET'],
    '/event' => ['POST'],
    '/reset' => ['POST']
];


?>