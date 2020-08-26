<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\Utils\ApplicationContext;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use App\JsonRpc\AppServiceInterface;

/**
 * @Controller(prefix="/agent")
 * @Middleware(AuthMiddleware::class)
 */
class CodeController extends BaseController
{

    /**
     * 获取列表
     *
     * @RequestMapping(path="getCodeList",methods = "get")
     * 
     */
public function getCodeList(RequestInterface $request)
{
    $name = $request->input('name',null);
    $one_class = $request->input('one_class',null);
    $two_class =  $request->input('two_class',null);
    $page = (int) $request->input('page', 1);
    $page_size = (int) $request->input('page_size', null);
    return $this->service->getAgentList($name, $one_class, $two_class, $page, $page_size);

}
}