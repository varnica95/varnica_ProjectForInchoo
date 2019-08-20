<?php

namespace Controllers;

use Core\Controller;
use Includes\ProfileValidation;
use Models\User;

class Profile extends Controller
{
    public $_error;
    public function index()
    {
        $this->view('Profile' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Profile/index.phtml');
    }

    public function update()
    {
        if (isset($_POST['update-submit'])) {
            $validation = new ProfileValidation($_POST);
            if ($validation->getPass()) {
                $profile = new User($_POST);

                $profile->updatePassword();

                $this->_error = $profile->getErrors();

                $this->index();

            } else {
                $this->view('Profile' . DIRECTORY_SEPARATOR . 'index');
                echo $this->view->render('Profile/index.phtml', [
                    'errors' => [$validation->getErrors(),
                            $this->_error
                    ]
                ]);

            }
        }
    }
}