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

namespace App\Exception\Handler;

use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler as BaseHandler;

use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class HttpExceptionHandler extends BaseHandler
{
    /**
     * Handle the exception, and return the specified result.
     * @param HttpException $throwable
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        var_dump(2);
        $this->logger->debug($this->formatter->format($throwable));

        $this->stopPropagation();

        $data = json_encode([
            'code' => $throwable->getStatusCode(),
            'msg' => $throwable->getMessage()
        ], JSON_UNESCAPED_UNICODE);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200)->withBody(new SwooleStream($data));
    }
}
