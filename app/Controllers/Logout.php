<?php


namespace Controllers;


use Core\Controller;
use Models\Session;

class Logout extends Controller
{
    public function index()
    {
        $this->view('Logout' . DIRECTORY_SEPARATOR . 'index');
        $this->view->render();
    }

    public function logout()
    {
        Session::destroy();

        $this->view('Logout' . DIRECTORY_SEPARATOR . 'index');
        $this->view->render();
    }
}