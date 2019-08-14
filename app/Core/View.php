<?php

namespace Core;

class View
{
    protected $view_file,
        $view_data;

    public function __construct($view_file, $view_data)
    {
        $this->view_file = $view_file;
        $this->view_data = $view_data;
    }

    public function render()
    {
        echo "!!!... " . $this->view_file . " ...!!!";
        if(file_exists('../app/Views/' . $this->view_file . '.phtml'))
        {
            require '../app/Views/' . $this->view_file . '.phtml';
        }
    }
}