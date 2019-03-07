<?php

namespace app\core\server;

class Controller
{
    protected function render($view, $params = [])
    {
        $viewPath = $_SERVER["DOCUMENT_ROOT"] . '/../views/';
        extract($params, EXTR_PREFIX_SAME, 'data');

        ob_start();
        ob_implicit_flush(false);
        require_once $viewPath . $view . '.php';
        $content = ob_get_clean();
        echo $content;
    }
}