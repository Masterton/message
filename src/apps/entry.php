<?php

return [
    //api 接口
    'api' => [
        'prefix' => '/api',
        'urls' => require __DIR__ . '/api/urls.php'
    ],
    // 主页接口
    'home' => [
        'prefix' => '/',
        'urls' => require __DIR__ . '/home/urls.php'
    ],
    // 数据库迁移接口
    'db' => [
        'prefix' => '/db',
        'urls' => require __DIR__ . '/db/urls.php'
    ],
    // 后台接口
    /*'admin' => [
        'prefix' => '/admin',
        'urls' => require __DIR__ . '/admin/urls.php'
    ],*/
];