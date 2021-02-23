<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\CodeDetailUpdate;
use App\Model\GgErrcodeListV2;
use App\Model\GgErrcodeV2Detail;
use App\Model\CodeRe;
use App\Model\Admin;
use App\Model\MyLog;
use App\Tool\Token;
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
    public function getcodelistdata(RequestInterface $request, ResponseInterface $response)
    {

        $one_class = $request->input('one_class', null);
        $two_class = $request->input('two_class', null);
        $page = (int)$request->input('page', 1);
        $page_size = (int)$request->input('limit', 20);
        $keyword = $request->input('keyword', '');
        $spn = $request->input('spn', '');
        $three_class =  (string)$request->input('three_class','');
        $data = CodeDetailUpdate::getCodeList($spn,$keyword,$page,$page_size,$one_class,$two_class,$three_class);
        return $response->json(['code' => 0, 'msg' => '加载成功！', 'data' => $data['data'],"count"=>$data['total'],'last'=>$data['last_page'],'limit'=>$page_size]);
        
    }

    /**
     * 获取列表页面
     *
     * @RequestMapping(path="showlisthtml",methods = "get")
     *
     */
    public function showlisthtml(RequestInterface $request, RenderInterface $render)
    {
        $token = new Token();
        $request_token = $request->input('token');
        $user_id = $request->input('user_id');
        if (empty($request_token) && empty($user_id)) {
            return $render->render('err', ['msg' => '没有登陆', 'url' => '/login/mylogin']);
        }
        $token_info = $token->get($request_token);
        if (!$token_info) {
            return $render->render('err', ['msg' => '登录过期，请重新登录', 'url' => '/login/mylogin']);
        }
        $user_info = Admin::query()->where(['id' => $user_id])->first(['username', 'avatar']);
        $one_class = $request->input('one_class','');
        $two_class =  $request->input('two_class','');
        $three_class =  (string)$request->input('three_class','');
        $page = (int) $request->input('page', 1);
        $page_size = (int) $request->input('limit', 20);
        $keyword = $request->input('keyword', '');
        $spn = $request->input('spn', '');
        $data = CodeDetailUpdate::getCodeList($spn,$keyword,$page,$page_size,$one_class,$two_class,$three_class);
        $one_select =array("ABS","Ecofit","VE/VP泵","五十铃","依米泰克","其他ECU","其他后处理","凯德斯","凯龙","单体泵","南岳","博世","博世2.0","博世2.2","博世6.5","卡特挖机","天然气","天纳克","威孚力达","小松挖机","康明斯","德尔福","挖机","新风","日立挖机","易控","潍柴自主","玉柴自主","电装","神钢挖机","艾可蓝","解放自主","重汽自主","其他");
        return $render->render('index',['code' => 0, 'msg' => '加载成功！', 'data' => $data['data'],"count"=>$data['total'],'last'=>$data['last_page'],'limit'=>$page_size,'one_select'=>$one_select,'keyword'=>$keyword,'spn'=>$spn,'username'=>$user_info['username']]);
    }
    /**
     * 新的获取列表页面
     *
     * @RequestMapping(path="newshowlisthtml",methods = "get")
     *
     */
    public function newshowlisthtml(RequestInterface $request, RenderInterface $render)
    {
        $token = new Token();
        $request_token = $request->input('token');
        $user_id = $request->input('user_id');
        if (empty($request_token) && empty($user_id)) {
            return $render->render('err', ['msg' => '没有登陆', 'url' => '/login/mylogin']);
        }
        $token_info = $token->get($request_token);
        if (!$token_info) {
            return $render->render('err', ['msg' => '登录过期，请重新登录', 'url' => '/login/mylogin']);
        }
        $user_info = Admin::query()->where(['id' => $user_id])->first(['username', 'avatar']);
        $one_class = $request->input('one_class','');
        $two_class =  $request->input('two_class','');
        $three_class =  (string)$request->input('three_class','');
        $page = (int) $request->input('page', 1);
        $page_size = (int) $request->input('limit', 20);
        $keyword = $request->input('keyword', '');
        $spn = $request->input('spn', '');
        $data = GgErrcodeListV2::getCodeList($spn,$keyword,$page,$page_size,$one_class,$two_class,$three_class);
        $one_select =array("ABS","Ecofit","VE/VP泵","五十铃","依米泰克","其他ECU","其他后处理","凯德斯","凯龙","单体泵","南岳","博世","博世2.0","博世2.2","博世6.5","卡特挖机","天然气","天纳克","威孚力达","小松挖机","康明斯","德尔福","挖机","新风","日立挖机","易控","潍柴自主","玉柴自主","电装","神钢挖机","艾可蓝","解放自主","重汽自主","其他");
        return $render->render('index',['code' => 0, 'msg' => '加载成功！', 'data' => $data['data'],"count"=>$data['total'],'last'=>$data['last_page'],'limit'=>$page_size,'one_select'=>$one_select,'keyword'=>$keyword,'spn'=>$spn,'username'=>$user_info['username']]);
    }
    /**
     * 获取二级分类
     *
     * @RequestMapping(path="getsecclass",methods = "get")
     *
     */
    public function getsecclass(RequestInterface $request)
    {
        $text = $request->input('onetag');
        if (empty($text)) {
            $data = [];
        } else {
            $data = CodeDetailUpdate::getTwoClass($text);
        }
        return $data;
    }

    /**
     * 获取列表页面
     *
     * @RequestMapping(path="code",methods = "get")
     *
     */
    public function code(RenderInterface $render, RequestInterface $request)
    {
        $token = new Token();
        $request_token = $request->input('token');
        if (empty($request_token)) {
            return $render->render('err', ['msg' => '没有登陆', 'url' => '/login/mylogin']);
        }
        $token_info = $token->get($request_token);
        if (!$token_info) {
            return $render->render('err', ['msg' => '登录过期，请重新登录', 'url' => '/login/mylogin']);
        }
        $id = $request->input('id', null);
        $data = CodeDetailUpdate::getCodeDetail($id);
        $news = [];
        $fac = [];
        if (!empty($data[0]['proObj'])) {
            $new = str_replace('\'', '"', (string)$data[0]['proObj']);
            $data_sec = json_decode($new, true);
            if (!empty($data_sec)) {
                foreach ($data_sec as $key => $val) {
                    $news[$key] = $val['proId'];
                }
            }
        } else {
            $data_sec = [];
        }
        return $render->render('code', ['data' => $data[0], 'new' => $news, 'data_sec' => $data_sec]);
    }

    /**
     * 获取指南
     *
     * @RequestMapping(path="showguide",methods = "get,post")
     *
     */
    public function showguide(RequestInterface $request,RenderInterface $render,ResponseInterface $response)
    {
        $token = new Token();
        $request_token = $request->input('token');
        if (empty($request_token)) {
            return $render->render('err', ['msg' => '没有登陆', 'url' => '/login/mylogin']);
        }
        $token_info = $token->get($request_token);
        if (!$token_info) {
            return $render->render('err', ['msg' => '登录过期，请重新登录', 'url' => '/login/mylogin']);
        }
        $id = $request->input('id');
        $text = $request->input('text');
        if (empty($id) || empty($text)) {
            return ['504'];
        }else{
            $data = CodeRe::getCodeGui($id,$text)[0];
            if(empty($data)){
                $res = $this->write_log($id,$text);
                return $response->json(['msg'=>'没有相关内容'.$res,'code'=>'400']);
                
            }else if(empty($data['content'])){
                return $response->json(['msg'=>'真的没有相关内容','code'=>'400']); 
            }
        }
        return $response->json(['msg'=>'查询成功','code'=>'200','data'=>$data]); 
    }

    /**
     * 改变故障码的标记状态
     *
     * @RequestMapping(path="changestatus",methods = "get")
     *
     */
    public function changestatus(RequestInterface $request)
    {
        $id = $request->input('id');
        $data = CodeDetailUpdate::changeStatus($id);
        return '更改已发送';
    }

    private function write_log($id,$text){
        return MyLog::save_data($id,$text);
    }
}
