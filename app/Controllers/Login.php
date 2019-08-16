<?php

namespace Controllers;

use Core\Controller;
use Models\User;

class Login extends Controller
{
    public function index()
    {
        $this->view('Login' . DIRECTORY_SEPARATOR . 'index');
        $this->view->render();
    }

    public function userLogin()
    {
        if (isset($_POST['login-submit']))
        {
            $newUser = new User($_POST);
            $newUser->userLogin();

            $this->view('Home' . DIRECTORY_SEPARATOR . 'index');
            $this->view->render();
            var_dump($_SESSION);
        }
    }
}