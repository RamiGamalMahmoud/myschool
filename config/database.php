<?php

/**
 * Database configrations goes here
 */
return [
    'driver' => 'mysql',

    'connections' => [

        'mysql' => [
            'db'       => 'myschool',
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'password' => '',
            'port'     => '3306',
            'userName' => 'root'
        ],

        'sqlite' => [],

        'sqlserver' => [],

        'oracle' => []
    ]
];
