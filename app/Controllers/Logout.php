<?php


namespace Controllers;


use Core\Controller;
use Models\Session;

class Logout extends Controller
{
    public function index()
    {
        $this->view('Logout' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Logout/index.phtml');
    }

    public function logout()
    {
        Session::destroy();

        $this->index();
    }
}