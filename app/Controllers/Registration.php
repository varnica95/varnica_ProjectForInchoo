<?php

namespace Controllers;

use Core\Controller;

class Registration extends Controller
{
    public function index()
    {
        $this->view('Registration' . DIRECTORY_SEPARATOR . 'index');
        $this->view->render();
    }

    public function iii()
    {
        echo "aaa";
    }
}