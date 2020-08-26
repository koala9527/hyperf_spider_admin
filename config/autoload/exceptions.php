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
    'handler' => [
        'http' => [
            App\Exception\Handler\HttpExceptionHandler::class,
            App\Exception\Handler\ValidationExceptionHandler::class,   //数据验证异常处理
            App\Exception\Handler\BusinessExceptionHandler::class,   //手动抛出异常
            App\Exception\Handler\AppExceptionHandler::class, //代码逻辑异常
        ],
        'jsonrpc' => [
            App\Exception\Handler\ValidationRpcExceptionHandler::class,
        ],
    ],
];
