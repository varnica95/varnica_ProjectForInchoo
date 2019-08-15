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
            var_dump($_POST);
            $newUser = new User($_POST);
            $newUser->userLogin();
           var_dump($newUser->getErrors());
        }
    }
}