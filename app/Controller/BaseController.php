<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BusinessException;
use App\Constants\ErrorCode;

abstract class BaseController
{
    protected $page_size = 20;
    
    protected $error_code;

    public function __construct()
    {   
        $this->error_code = new ErrorCode();
    } 

    /**
     * 操作成功跳转的快捷方法
     * 
     * @access protected
     * @param mixed $msg 提示信息
     * @param mixed $data 返回的数据
     * @return array $result
     */
    protected function success($data = '', string $msg = '成功！')
    {
        $result = [
            'code' => 200,
            'msg'  => $msg,
            'data' => $data,
        ];
        return $result;
    }

    /**
     * 操作失败跳转的快捷方法
     * 
     * @access protected
     * @param integer $code 返回的错误代码
     * @param string $msg 返回错误信息
     */
    protected function error(int $code = 1001, string $msg = '')
    {
        throw new BusinessException($code, $msg);
    }
}
