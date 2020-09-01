<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use Hyperf\Utils\ApplicationContext;
use App\JsonRpc\CeshiServiceInterface;

class IndexController extends AbstractController
{
    //     /**
    //  * 代理商服务
    //  *
    //  * @var CeshiServiceInterface
    //  */
    // private $service;

    // public function __construct()
    // {
    //     $this->service = ApplicationContext::getContainer()->get(CeshiServiceInterface::class);
    // }

    // public function index()
    // {
    //     $testdata =  $this->service->addComplaintData();
    //     return [
    //         'test'=>$testdata
    //     ];
    // }

    public function test()
    {
        return [
            'test'=>'suc'
        ];
    }

}