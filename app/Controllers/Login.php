<?php

namespace Controllers;

use Core\Controller;

class Login extends Controller
{
    public function index()
    {
        $this->view('Login' . DIRECTORY_SEPARATOR . 'index');
        $this->view->render();
    }
}