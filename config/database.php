<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'public' => [
            'driver'    => env('DB_DRIVER', 'pgsql'),
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', '5432'),
            'database'  => env('DB_DATABASE', 'forge'),
            'username'  => env('DB_USERNAME', 'forge'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'prefix'    => '',
            'schema'    => 'public',
            'sslmode'   => 'prefer',
        ],

        'administrator' => [
            'driver'    => env('DB_DRIVER', 'pgsql'),
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', '5432'),
            'database'  => env('DB_DATABASE', 'forge'),
            'username'  => env('DB_USERNAME', 'forge'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'prefix'    => '',
            'schema'    => 'administrator',
            'sslmode'   => 'prefer',
        ],

        'temporary_work' => [
            'driver'    => env('DB_DRIVER', 'pgsql'),
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', '5432'),
            'database'  => env('DB_DATABASE', 'forge'),
            'username'  => env('DB_USERNAME', 'forge'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'prefix'    => '',
            'schema'    => 'tempory_work',
            'sslmode'   => 'prefer',
        ],

        'data_warehouse' => [
            'driver'    => env('DB_DRIVER', 'pgsql'),
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', '5432'),
            'database'  => env('DB_DATAWAREHOUSE', 'forge'),
            'username'  => env('DB_USERNAME', 'forge'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'prefix'    => '',
            'schema'    => 'public',
            'sslmode'   => 'prefer',
        ],

        'external_connection' => [
            'driver'    => '',
            'host'      => '',
            'port'      => '',
            'database'  => '',
            'username'  => '',
            'password'  => '',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => true,
            'engine'    => null,
        ],

        'server_external_consult' => [
            'driver'    => '',
            'host'      => '',
            'port'      => '',
            'database'  => '',
            'username'  => '',
            'password'  => '',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => true,
            'engine'    => null,
        ],

        'auditory' => [
            'driver'    => env('DB_DRIVER_AUDITORY', 'pgsql'),
            'host'      => env('DB_HOST_AUDITORY', '127.0.0.1'),
            'port'      => env('DB_PORT_AUDITORY', '5432'),
            'database'  => env('DB_AUDITORY', 'forge'),
            'username'  => env('DB_USERNAME_AUDITORY', 'forge'),
            'password'  => env('DB_PASSWORD_AUDITORY', 'e3ccae410a'),
            'charset'   => 'utf8',
            'prefix'    => '',
            'schema'    => 'public',
            'sslmode'   => 'prefer',
        ],

        'bodega' => [
            'driver'    => env('DB_DRIVER_BODEGA', 'pgsql'),
            'host'      => env('DB_HOST_BODEGA', '127.0.0.1'),
            'port'      => env('DB_PORT_BODEGA', '5432'),
            'database'  => env('DB_BODEGA', 'forge'),
            'username'  => env('DB_USERNAME_BODEGA', 'forge'),
            'password'  => env('DB_PASSWORD_BODEGA', ''),
            'charset'   => 'utf8',
            'prefix'    => '',
            'schema'    => 'public',
            'sslmode'   => 'prefer',
        ]

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host'      => env('REDIS_HOST', '127.0.0.1'),
            'password'  => env('REDIS_PASSWORD', null),
            'port'      => env('REDIS_PORT', 6379),
            'database'  => 0,
        ],

    ],

];
