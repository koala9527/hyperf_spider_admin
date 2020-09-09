<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
   
    'default' => [
        'driver' => env('DB_XCWY_DRIVER', 'mysql'),
        'read' => [
            'host' => env('DB_XCWY_READ_HOST') ? explode(',', env('DB_XCWY_READ_HOST')) : [env('DB_XCWY_HOST', 'localhost')],
        ],
        'write' => [
            'host' => [env('DB_XCWY_WRITE_HOST') ?: env('DB_XCWY_HOST', 'localhost')],
        ],
        'database' => env('DB_XCWY_DATABASE', 'hyperf'),
        'username' => env('DB_XCWY_USERNAME', 'root'),
        'password' => env('DB_XCWY_PASSWORD', ''),
        'charset' => env('DB_XCWY_CHARSET', 'utf8mb4'),
        'collation' => env('DB_XCWY_COLLATION', 'utf8mb4_general_ci'),
        'prefix' => env('DB_XCWY_PREFIX', ''),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 50,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('DB_XCWY_MAX_IDLE_TIME', 60),
        ],
        'cache' => [
            'handler' => Hyperf\ModelCache\Handler\RedisHandler::class,
            'cache_key' => 'mc:%s:m:%s:%s:%s',
            'prefix' => 'default',
            'ttl' => 3600 * 24,
            'empty_model_ttl' => 600,
            'load_script' => true,
        ],
        'commands' => [
            'db:model' => [
                'path' => 'app/Model',
                'force_casts' => true,
                'inheritance' => 'Model',
            ],
        ],
    ]
];
