<?php

return [

    'name' => 'myschool',

    'root_url' => $_SERVER['SERVER_ADMIN'] === 'localhost' ? '/myschool/' : '/',

    'document_root' => $_SERVER['SERVER_ADMIN'] === 'localhost' ? '/myschool/public/' : '/',

    'db_connection' => 'mysql',

    'time_zone' => 'Africa/Cairo',

    'providers' => [
        SM\Providers\AppServiceProvider::class
    ]
];
