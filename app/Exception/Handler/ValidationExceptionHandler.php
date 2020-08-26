<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Validation\ValidationExceptionHandler as Handler;
use Hyperf\Validation\ValidationException;
use APP\Constants\ErrorCode;
use Throwable;

class ValidationExceptionHandler extends Handler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $message = $throwable->validator->errors()->first();
        if ($message) {
            $data = json_encode([
                'code' => 1015,
                'msg' => $message,
            ], JSON_UNESCAPED_UNICODE);
            $this->stopPropagation();
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200)->withBody(new SwooleStream($data));
        }
        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}
