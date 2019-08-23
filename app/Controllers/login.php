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
        $this->view('login' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Login/index.phtml');
    }

    public function userLogin()
    {
        if (isset($_POST['login-submit']))
        {
            $user = new User($_POST);

            if(isset($_POST['remember']))
                $remember = ($_POST['remember'] === 'on') ? true : false;
            else
                $remember = false;

            if(!$user->userLogin($remember))
            {
                $this->view('login' . DIRECTORY_SEPARATOR . 'index');
                echo $this->view->render('Login/index.phtml', [
                   'errors' => $user->getErrors(),
                ]);
            }else {
                $this->view('home' . DIRECTORY_SEPARATOR . 'index');
                echo $this->view->render('Home/index.phtml', [
                    'success' => 'Welcome. You are now logged in.'
                    ]);
            }
        }
    }
}