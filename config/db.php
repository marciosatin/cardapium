<?php

return [
     'default_connection' => [
        'driver' => getenv('DB_DRIVER'),
        'host' => 'db',
        'database' => getenv('DB_DATABASE'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci'
    ]
];
