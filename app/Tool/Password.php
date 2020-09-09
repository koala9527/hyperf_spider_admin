<?php

declare(strict_types=1);

namespace App\Tool;

/**
 * 密码生成器
 */
class Password
{
    /**
     * 密码key，不能修改！！！修改会导致所有用户无法登陆。
     *
     * @var string
     */
    private $user_key = 'v9$MXU5ouT#$UI$8GtGiQA72LMMnlsYU';

    /**
     * 基于user_key生成密码
     *
     * @param string $password
     * @return string
     */
    public function createPassword(string $password): string
    {
        return md5($this->user_key . $password);
    }
}
