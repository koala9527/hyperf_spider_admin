<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("Server Error！")
     */
    const SERVER_ERROR = 500;
    
    // 1001 接口不存在
    // 1002 token不存在
    // 1003 token错误
    // 1004 账号或密码错误
    // 1005 注销失败
    // 1006 账号目前不可用
    // 1007 找不到用户
    // 1008 没有管理员权限
    // 1009 信息验证失败
    // 1010 缺少必要参数
    // 1011 添加失败
    // 1012 修改失败
    // 1013 获取失败
    // 1014 删除失败
    // 1015 验证失败
    // 1016 错误的图片类型
    // 1017 文件不存在
    // 1018 密码错误
    // 1019 重复数据
    // 1020 绑定失败
    // 1021 公众号配置不存在
    // 1022 小程序不存在
    // 1030 case不存在
    // 1031 找不到数据
    // 1032 阿里云上传文件错误
    // 1033 已经绑定过代理了
    // 1034 在黑名单中
}
