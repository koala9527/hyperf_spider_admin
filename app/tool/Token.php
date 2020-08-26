<?php

namespace App\Tool;

use Hyperf\Utils\ApplicationContext;

/**
 * token 用来设置更新和获取token相关的信息
 */
class Token
{
    /**
     * token名称
     *
     * @var string
     */
    protected $token_name = '__adminToken__';

    /**
     * token过期时间（以秒计算）
     *
     * @var integer
     */
    protected $expire = 3600;

    /**
     * token长度
     * @var integer
     */
    protected $token_length = 96;

    /**
     * 缓存
     * @var \Psr\SimpleCache\CacheInterface
     */
    protected $cache;

    public function __construct()
    {
        $container = ApplicationContext::getContainer();
        $this->cache = $container->get(\Psr\SimpleCache\CacheInterface::class);
    }

    /**
     * 获取缓存的token名称
     * 
     * @param string $token
     * @return string 返回token名称
     */
    private function getTokenName(string $token)
    {
        return '__adminToken__' . $token;
    }

    /**
     * 获取token字符串
     * 制造一个指定长度的唯一的字符串
     * @param integer $len 长度
     * @return string 字符串
     */
    private function getTokenStr(int $len)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';//64位长度
        $string = microtime(true) * 10000;// 15705264142655   14位
        $len -= strlen($string); //固定长度，$len固定长度为96 ，96-14=82
        for (; $len > 1; $len--) { //循环82次
            $position = rand() % strlen($chars);//0-32768 % 64 的余数(0-63)
            $position2 = rand() % strlen($string);//0-32768 % 14 的余数 (0-13)
            $string = substr_replace($string, substr($chars, $position, 1), $position2, 0);//往15705264142655循环随机插入$chars里面的随机字母 。最终生成随机的95长度的字符串
        }
        return $string;
    }

    /**
     * 校验token是否存在
     * 
     * @param string $token
     * @return bool
     */
    public function check(string $token)
    {
        $token_name = $this->getTokenName($token);
        $info = $this->cache->get($token_name);
        return $info ? true : false;
    }

    /**
     * 设置token
     *
     * @param integer $uid 用户id
     * @param array $info 需要缓存的信息，可以是头像用户名称等
     * @return string|false str 成功返回token值，失败返回 false  
     */
    public function set(int $uid, array $info, int $expire = 0)
    {
        $expire = $expire ?: $this->expire;//过期时间1个小时
        $token = $this->getTokenStr($this->token_length);//获取一个长度95的随机字符串
        $token_name = $this->getTokenName($token);
        if ($this->cache->get($token_name)) return false;//有了就不设置了
        $token_info = [
            'uid' => $uid,
            'info' => $info,
            'create_time' => time(),
        ];
        $this->cache->set($token_name, $token_info, $expire);//设置token键值和过期时间
        return $token;
    }

    /**
     * 获取token存储的信息
     * 
     * @param string $token
     * @return array|false str 成功返回token信息，失败返回 false
     */
    public function get(string $token)
    {
        $token_name = $this->getTokenName($token);
        $info = $this->cache->get($token_name);
        if (!$info) return false;
        $this->update($token, $info['info']);
        return $info;
    }

    /**
     * 更新token
     * 
     * @param string $token
     * @param array $info token需要存储的内容
     * @return bool 成功返回true 失败返回 false
     */
    public function update(string $token, array $info = null)
    {
        $token_name = $this->getTokenName($token);
        $token_info = $this->cache->get($token_name);
        if (!$token_info) return false;
        $token_info['update_time'] = time();
        $token_info['info'] = $info ? $info : $token_info['info'];
        $expire = $info['is_admin'] ? 86400 : $this->expire;
        $this->cache->set($token_name, $token_info, $expire);
        return true;
    }

    /**
     * 删除token
     * 
     * @param string $token
     * @return bool 成功返回true 失败返回 false
     */
    public function delete(string $token)
    {
        $token_name = $this->getTokenName($token);
        $this->cache->delete($token_name);
        return true;
    }
}
