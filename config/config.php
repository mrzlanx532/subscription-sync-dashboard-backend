<?php

return [
    'database' => [
        'adapter' => 'mysql',
        'host' => $_ENV['DB_HOST'] ?? 'mysql',
        'port' => $_ENV['DB_PORT'] ?? 3306,
        'dbname' => $_ENV['DB_DATABASE'] ?? 'app',
        'username' => $_ENV['DB_USERNAME'] ?? 'app',
        'password' => $_ENV['DB_PASSWORD'] ?? 'secret',
        'charset' => 'utf8mb4',
    ],
];
