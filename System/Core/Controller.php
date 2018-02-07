<?php

namespace easyAdmin\Core;

use EasySwoole\Core\Http\AbstractInterface\Controller as HTTPController;

abstract class Controller extends HTTPController
{
    /* @var View $view */
    protected $view;

    function display($content, $vars = [], $config = [])
    {
        $this->view->display($content, $vars, $config);
    }

    function fetch($template, $vars = [], $config = [])
    {
        $this->view->fetch($template, $vars, $config);
    }

    function assign($name, $value = '')
    {
        $this->view->assign($name, $value);
    }

    protected function onRequest($action): ?bool
    {
        $this->view = new View;
        $this->view->setView($this->request(), $this->response());
        return parent::onRequest($action);
    }
}