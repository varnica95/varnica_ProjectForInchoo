<?php


namespace Core;


class Router
{
    protected $controller = '',
              $action,
              $prams;

    public function __construct()
    {
        $this->run();
    }

    protected function prepareURL()
    {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        $url = explode('/', $request);

        if (empty($url[0]))
        {
            $url[0] = 'Home';
        }
        $this->controller = isset($url[0]) ?  'Controllers\\' . ucfirst($url[0])  : 'Home';
        $this->action = isset($url[1]) ? ucfirst($url[1]) : 'index';
        var_dump($this->controller);
        unset($url[0], $url[1]);

        $this->prams = !empty($url) ? array_values($url) : array();

    }

    public function run()
    {
        $this->prepareURL();
        $this->controller = new $this->controller();

        call_user_func_array([$this->controller, $this->action], $this->prams);
    }
}