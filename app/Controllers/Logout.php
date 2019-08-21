<?php


namespace Controllers;


use Core\Controller;
use Models\Config;
use Models\Cookie;
use Models\Session;
use Models\User;

class Logout extends Controller
{
    public function index()
    {
        $this->view('Logout' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Logout/index.phtml');
    }

    public function logout()
    {
        User::DeleteCookie(Session::get('id'));
        Session::destroy();
        Cookie::delete(Config::getInstance()->getConfig("remember/cookie_name"));

        $this->index();
    }
}