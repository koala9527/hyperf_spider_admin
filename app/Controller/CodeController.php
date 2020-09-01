<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Controller;
//use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\DbConnection\Db;

/**
 * @Controller(prefix="/agent")

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
        $data = Db::connection('XCWY')->select('SELECT * FROM code_res limit 1;');
        return $data;

    }


}