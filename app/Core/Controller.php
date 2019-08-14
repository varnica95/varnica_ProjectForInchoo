<?php

namespace Core;

class Controller
{
    protected $view;

    public function view($viewName, $data = array())
    {
        $this->view = new View($viewName, $data);

        return $this->view;
    }
}