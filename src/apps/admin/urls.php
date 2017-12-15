<?php
return [

    // 后台主页
    '/home[/]' => [
        'get' => [
            'handler' => "App\Controllers\AdminHomeController:index",
            'name'    => 'admin_get_home',
            'auth'    => true,
            'op_class' => '后台',
            'op_name' => '主页',
        ],
    ],
];