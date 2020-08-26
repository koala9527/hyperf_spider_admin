<?php

declare(strict_types=1);

namespace App\Exception;

use App\Constants\ErrorCode;
use Hyperf\Server\Exception\ServerException;
use Throwable;

class BusinessException extends ServerException
{
    public function __construct(int $code = 0, string $msg = null, Throwable $previous = null)
    {
        if (is_null($msg) || $msg == '') {
            $msg = ErrorCode::getMessage($code);
        }

        parent::__construct($msg, $code, $previous);
    }
}
