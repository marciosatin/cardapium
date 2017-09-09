<?php

require __DIR__ . '/vendor/autoload.php';

if(file_exists(__DIR__ .'/.env')) {
    $dotenv = new \Dotenv\Dotenv(__DIR__);
    $dotenv->overload();
}

$db = include __DIR__ . '/config/db.php';

$default_connection = $db['default_connection'];

return [
    'paths' => [
        'migrations' => [
            __DIR__ . '/db/migrations'
        ],
//        'seeds' => [
//            __DIR__ . '/db/seeds'
//        ]
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_database' => 'default_connection',
        'default_connection' => [
            'adapter' => $default_connection['driver'],
            'host' => $default_connection['host'],
            'name' => $default_connection['database'],
            'user' => $default_connection['username'],
            'pass' => $default_connection['password'],
            'charset' => $default_connection['charset'],
            'collation' => $default_connection['collation']
        ]
    ]
];