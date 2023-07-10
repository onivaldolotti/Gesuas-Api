<?php

return [
    'paths' => [
        'migrations' => 'src/Infrastructure/Database/migrations',
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'sqlite',
            'host' => 'localhost',
            'name' => 'database.sqlite',
            'user' => 'root',
            'pass' => '',
            'port' => '',
            'charset' => 'utf8',
        ],
    ],
];
