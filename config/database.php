<?php

use Illuminate\Support\Str;

return [

    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', env('MYSQLHOST', '127.0.0.1')),      // Railway: MYSQLHOST
            'port' => env('DB_PORT', env('MYSQLPORT', '3306')),             // Railway: MYSQLPORT
            'database' => env('DB_DATABASE', env('MYSQL_DATABASE', 'forge')), // Railway: MYSQL_DATABASE
            'username' => env('DB_USERNAME', env('MYSQLUSER', 'forge')),    // Railway: MYSQLUSER
            'password' => env('DB_PASSWORD', env('MYSQLPASSWORD', '')),     // Railway: MYSQLPASSWORD
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', env('PGHOST', '127.0.0.1')),
            'port' => env('DB_PORT', env('PGPORT', '5432')),
            'database' => env('DB_DATABASE', env('PGDATABASE', 'forge')),
            'username' => env('DB_USERNAME', env('PGUSER', 'forge')),
            'password' => env('DB_PASSWORD', env('PGPASSWORD', '')),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

    ],

    'migrations' => 'migrations',

];
