<?php


namespace App\Service\JsonRpc;

use Hyperf\RpcServer\Annotation\RpcService;

/**
 * 后台服务移动端
 * @RpcService(name="TestCeshiService", protocol="jsonrpc", server="jsonrpc", publishTo="consul")
 */
class CeshiService
{
    public function addComplaintData()
    {
        return ['调用成功'];
    }
}
