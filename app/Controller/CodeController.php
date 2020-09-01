<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\CodeDetailUpdate;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\View\RenderInterface;

//use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\DbConnection\Db;

/**
 * @Controller(prefix="/admin/agent")

 */
class CodeController extends BaseController
{
    /**
     * 获取列表
     *
     * @RequestMapping(path="getcodelistdata",methods = "get")
     * 
     */
    public function getcodelistdata(RequestInterface $request,ResponseInterface $response)
    {
        $one_class = $request->input('one_class',null);
        $two_class =  $request->input('two_class',null);
        $page = (int) $request->input('page', 1);
        $page_size = (int) $request->input('limit', 20);
        $keyword = $request->input('keyword', '');
        $data = CodeDetailUpdate::getCodeList($keyword,$page,$page_size,$one_class,$two_class);
        return $response->json(['code' => 0, 'msg' => '加载成功！', 'data' => $data['data'],"count"=>$data['total'],'last'=>$data['last_page'],'limit'=>$page_size,'limits'=>[20,30,50,100]]);
        
    }

    /**
     * 获取列表页面
     *
     * @RequestMapping(path="showlisthtml",methods = "get")
     * 
     */
    public function showlisthtml(RenderInterface $render)
    {
        return $render->render('index');
    }
    


}