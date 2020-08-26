<?php

declare(strict_types=1);

use Hyperf\JsonRpc\JsonRpcPoolTransporter;
use Hyperf\JsonRpc\JsonRpcTransporter;
use Hyperf\Utils\Serializer\SerializerFactory;
use Hyperf\Utils\Serializer\Serializer;

return [
    App\Tool\WechatRequestInterface::class => App\Tool\WechatRequest::class,
    Hyperf\Contract\NormalizerInterface::class => new SerializerFactory(Serializer::class),
    // JsonRpcTransporter::class => JsonRpcPoolTransporter::class,
];
