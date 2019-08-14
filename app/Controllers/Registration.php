<?php

namespace Controllers;

use Core\Controller;
use Models\User;

class Registration extends Controller
{
    public function index()
    {
        $this->view('Registration' . DIRECTORY_SEPARATOR . 'index');
        $this->view->render();
    }

    public function createNew()
    {
        if (isset($_POST['signup-submit'])){
            $newUser = new User($_POST);
            $newUser->newUser();
        }


    }
}