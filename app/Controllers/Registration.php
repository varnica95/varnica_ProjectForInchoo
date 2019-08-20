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
        echo $this->view->render('Registration/index.phtml');
    }

    public function createNew()
    {
        if (isset($_POST['signup-submit'])) {
            $validation = new Validation($_POST);
            if ($validation->getPass()) {
                $newUser = new User($_POST);
                $newUser->newUser();
            } else {
                $this->view('Registration' . DIRECTORY_SEPARATOR . 'index');
                echo $this->view->render('Registration/index.phtml', [
                    'errors' => $validation->getErrors()
                ]);
            }
        }

    }
}