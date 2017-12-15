<?php

return [
    '/ping[/]' => [
        'get' => [
            'handler' => function(\Slim\Http\Request  $request, \Slim\Http\Response  $response, $args=[]) {
                $response->getBody()->write("45465465");
                return $response;
            },
            'name' => 'api_ping',
            'auth' => false
        ],
    ],

    '/test[/]' => [
        'post' => [
            'handler' => 'App\Controllers\HomeController:test',
            'name' => 'api_get_test',
            'auth' => false
        ],
    ],

    '/insert/socket/token[/]' => [
        'get' => [
            'handler' => 'App\Controllers\HomeController:insertSocketToken',
            'name' => 'api_get_insert_socket_token',
            'auth' => false
        ],
    ],
    '/delete/socket/token[/]' => [
        'get' => [
            'handler' => 'App\Controllers\HomeController:deleteSocketToken',
            'name' => 'api_get_delete_socket_token',
            'auth' => false
        ],
    ],
    '/get/socket/token[/]' => [
        'get' => [
            'handler' => 'App\Controllers\HomeController:getSocketToken',
            'name' => 'api_get_socket_token',
            'auth' => false
        ],
    ],
];