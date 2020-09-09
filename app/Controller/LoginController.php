<?php

declare(strict_types=1);

namespace App\Controller;


use App\Middleware\AuthMiddleware;
use App\Tool\Password;
use App\Tool\Token;
use App\Model\Admin;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\View\RenderInterface;


/**
 * @Controller(prefix="/login")
 */
class LoginController extends BaseController
{
    /**
     * 用户登录
     * @RequestMapping(path="login",method="post")
     */
    public function login(RequestInterface $request)
    {
        $password_tool = new Password();
        $username = $request->input('username');
        $password = $password_tool->createPassword((string)$request->input('password'));
        $user_info = Admin::query()->where(['username' => $username, 'password' => $password])->first(['id', 'username', 'nickname', 'avatar', 'phone', 'email', 'status', 'is_admin']);
        if (!$user_info) $this->error(1004, '账号或密码错误');
        if (!$user_info['status']) $this->error(1006, '账号目前不可用');
        $data = [
            'uid'=>$user_info['id'],
            'is_admin'=>$user_info['is_admin']
        ];
        $token = new Token;
        $expriess = $user_info['is_admin']?86400:0;
        $res = [
            'token' => $token->set($user_info['id'],$data,$expriess)//每次登录之后会重置token,以前的token失效。然后把token传给前端。前端有新的请求都会携带token。经过有中间件的控制器方法时候都会判断token是不是有效
        ];
        return $this->success($res,'登陆成功！');
    }

    
    /**
     * 用户注册
     * @RequestMapping(path="register",methods="post") 
     */
    public function register(RequestInterface $request)
    {
        $password_tool = new Password();
        $username = $request->input('username');
        $password = $password_tool->createPassword((string)$request->input('password'));
        $user_info = Admin::query()->where(['username' => $username])->first();
        if ($user_info) $this->error(1004, '账号已存在');
        $user_info = Admin::firstOrCreate(['username' => $username,'password'=>$password]);
        return $this->success('','注册成功！');
    }

    /**
     * 注销登录
     * @RequestMapping(path="logout",methods="post")
     * @Middleware(AuthMiddleware::class)
     */
    public function loginout(RequestInterface $request)
    {
        $token = new Token();
        $res = $token->delete($request->getHeader('token')[0]);
        if($res) return $this->success("","注销成功");
        $this->error(1005,'注销失败');
    }
    /**
     * 我的登录
     * 
     * @RequestMapping(path="mylogin",methods="get,post")
     */
    public function mylogin(RenderInterface $render)
    {
        return $render->render('login');
    }

        /**
     * 我的登录
     * 
     * @RequestMapping(path="checklogin",methods="get,post")
     */
    public function checklogin(RequestInterface $request,ResponseInterface $response)
    {
        $password_tool = new Password();
        $username = $request->input('username');
        $password = $password_tool->createPassword((string)$request->input('password'));
        $user_info = Admin::query()->where(['username' => $username, 'password' => $password])->first(['id', 'username', 'nickname', 'avatar', 'phone', 'email', 'status', 'is_admin']);
        if (!$user_info) $this->error(1004, '账号或密码错误');
        if (!$user_info['status']) $this->error(1006, '账号目前不可用');
        $data = [
            'uid'=>$user_info['id'],
            'is_admin'=>$user_info['is_admin']
        ];
        $token = new Token;
        $expriess = $user_info['is_admin']?86400:0;
        $res = [
            'token' => $token->set($user_info['id'],$data,$expriess),
            'user_id'=>$user_info['id'],
            //每次登录之后会重置token,以前的token失效。然后把token传给前端。前端有新的请求都会携带token。经过有中间件的控制器方法时候都会判断token是不是有效
        ];
        return $this->success($res,'登陆成功');
    }

    /**
     * 注销登录
     * 
     * @RequestMapping(path="mylogout",methods="get,post")
     */
    public function mylogout(RequestInterface $request,ResponseInterface $response)
    {
        $token = new Token();
        $res = $token->delete($request->input('token'));
        if($res) return $this->success("","注销成功");
        $this->error(1005,'注销失败');
    }
    
}
