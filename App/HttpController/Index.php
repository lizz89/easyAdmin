<?php

namespace App\HttpController;

use easyAdmin\Core\Controller;

/**
 * 默认前台首页
 * Class Index
 * @author  : evalor <master@evalor.cn>
 * @package App\HttpController
 */
class Index extends Controller
{
    function index()
    {
        $this->fetch('index');
    }
}