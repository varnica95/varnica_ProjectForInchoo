<?php

namespace Controllers;

use Core\Controller;
use Includes\ProfileValidation;
use Models\User;

class Profile extends Controller
{
    public function index()
    {
        $this->view('Profile' . DIRECTORY_SEPARATOR . 'index');
        $this->view->render();
    }

    public function update()
    {
        if (isset($_POST['update-submit'])) {
            $validation = new ProfileValidation($_POST);
            if ($validation->getPass()) {
                $profile = new User($_POST);

                $profile->updatePassword();

            } else {
                $this->index();
                var_dump($validation->getErrors());
            }
        }
    }
}