<?php

namespace Controllers;

use Core\Controller;
use Includes\Validation;
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
        if (isset($_POST['signup-submit'])) {
            $validation = new Validation($_POST);
            if ($validation->getPass()) {
                $newUser = new User($_POST);
                $newUser->newUser();
            } else {
                $this->index();
                var_dump($validation->getErrors());
            }
        }

    }
}