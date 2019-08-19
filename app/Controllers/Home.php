<?php

namespace Controllers;

use Core\Controller;

class Home extends Controller
{
    public function index()
    {

        $this->view('Home' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Home/index.phtml');
    }
}