<?php

namespace Controllers;

if (!isset($_SESSION))
session_start();

use Core\Controller;
use Models\Session;
use Models\User;

class Login extends Controller
{
    public function index()
    {
        $this->view('Login' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Login/index.phtml');
    }

    public function userLogin()
    {
        if (isset($_POST['login-submit']))
        {
            $user = new User($_POST);
            if(!$user->userLogin())
            {

                $this->view('Login' . DIRECTORY_SEPARATOR . 'index');
                echo $this->view->render('Login/index.phtml', [
                   'errors' => $user->getErrors(),
                ]);
            }else {
                $this->view('Home' . DIRECTORY_SEPARATOR . 'index');
                echo $this->view->render('Home/index.phtml');
            }
        }
    }
}