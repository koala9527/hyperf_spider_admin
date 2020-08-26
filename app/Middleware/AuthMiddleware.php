<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Utils\Context;
use App\Exception\BusinessException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use APP\Constants\ErrorCode;
use App\Tool\Token;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = new Token();
        if (!$request->hasHeader('token')) throw new BusinessException(1002, '暂未登录');
        $request_token = $request->getHeader('token')[0];
        $token_info = $token->get($request_token);
        if (!$token_info) throw new BusinessException(1003, '登录已失效');
        $request = $request->withAttribute('info', $token_info['info']);
        $request = $request->withAttribute('uid', $token_info['uid']);
        $request = $request->withAttribute('is_admin', $token_info['info']['is_admin']);
        Context::set(ServerRequestInterface::class, $request);
        return $handler->handle($request);
    }
}
