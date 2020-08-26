<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\Validation\ValidationException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Rpc\ProtocolManager;
use Hyperf\Rpc\Protocol;
use Hyperf\Utils\Context;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;
use Throwable;

/**
 * 系统内手动抛出异常处理器
 */
class ValidationRpcExceptionHandler extends ExceptionHandler
{
    /**
     * @var Hyperf\Rpc\Contract\DataFormatterInterface
     */
    protected $dataFormatter;

    /**
     * @var \Hyperf\Contract\PackerInterface
     */
    protected $packer;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $protocolName = 'jsonrpc';

    /**
     * ValidationRpcExceptionHandler constructor.
     *
     * @param ContainerInterface $container
     * @param ProtocolManager $protocolManager
     * @param LoggerFactory $loggerFactory
     */
    public function __construct(ContainerInterface $container, ProtocolManager $protocolManager, LoggerFactory $loggerFactory)
    {
        $protocol = new Protocol($container, $protocolManager, $this->protocolName);
        $this->dataFormatter = $protocol->getDataFormatter();
        $this->packer = $protocol->getPacker();
        $this->logger = $loggerFactory->get('log', 'default');
    }

    /**
     * @param ValidationException $throwable
     * @param ResponseInterface $response
     * @return \Hyperf\HttpMessage\Server\Response
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());

        $data = [
            'code' => $throwable->getCode(),
            'msg' => $throwable->getMessage(),
        ];
        // 阻止异常冒泡
        $this->stopPropagation();
        return $this->buildResponse($this->request(), $data);
    }

    /**
     * @param ServerRequestInterface $request
     * @param $response
     * @return ResponseInterface
     */
    protected function buildResponse(ServerRequestInterface $request, $response): ResponseInterface
    {
        $body = new SwooleStream($this->formatResponse($response, $request));
        return $this->response()
            ->withAddedHeader('content-type', 'application/json')
            ->withBody($body);
    }

    /**
     * @param $response
     * @param ServerRequestInterface $request
     * @return string
     */
    protected function formatResponse($response, ServerRequestInterface $request): string
    {
        $response = $this->dataFormatter->formatResponse([$request->getAttribute('request_id'), $response]);
        return $this->packer->pack($response);
    }
    /**
     * Get response instance from context.
     */
    protected function response(): ResponseInterface
    {
        return Context::get(ResponseInterface::class);
    }
    /**
     * Get request instance from context.
     */
    protected function request(): ServerRequestInterface
    {
        return Context::get(ServerRequestInterface::class);
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
