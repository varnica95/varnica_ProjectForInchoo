<?php


namespace Core;


class Router
{
    protected $controller = '';
    protected $action;
    protected $params;

    public function __construct()
    {

    }

    protected function prepareURL()
    {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        $url = explode('/', $request);

        if (empty($url[0])) {
            $url[0] = 'home';
        }
        $this->controller = isset($url[0]) ? 'Controllers\\' . $url[0] : 'home';
        $this->action = isset($url[1]) ? $url[1] : 'index';
        unset($url[0], $url[1]);

        $this->params = !empty($url) ? array_values($url) : array();

    }

    public function run()
    {
        $this->prepareURL();
        $this->controller = new $this->controller();

        call_user_func_array([$this->controller, $this->action], $this->params);
    }
}