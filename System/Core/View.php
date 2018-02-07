<?php

namespace easyAdmin\Core;

use EasySwoole\Config;
use EasySwoole\Core\Http\Response;
use EasySwoole\Core\Http\Request;
use think\Template;

/**
 * Class View
 * @author  : evalor <master@evalor.cn>
 * @package easyAdmin\Core
 */
class View extends Template
{
    /* @var Request $request */
    protected $request;
    /* @var Response $response */
    protected $response;

    function __construct(array $config = [])
    {
        // 全局配置自动加载
        $templateOptions = Config::getInstance()->getConf('template');
        if (!empty($config)) {
            $templateOptions = array_merge($templateOptions, $config);
        }
        parent::__construct($templateOptions);
    }

    function setView(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    function fetch($template, $vars = [], $config = [])
    {
        $this->obContent(function () use ($template, $vars, $config) {
            parent::fetch($template, $vars, $config);
        });
    }

    function display($content, $vars = [], $config = [])
    {
        $this->obContent(function () use ($content, $vars, $config) {
            parent::display($content, $vars, $config);
        });
    }

    function obContent(\Closure $closure)
    {
        ob_start();
        $closure();
        $this->response->write(ob_get_clean());
    }
}