<?php

namespace Controllers;

use Core\Controller;
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
        if (isset($_POST['update-submit']))
        {
            echo "z";
            $update = new User($_POST);
            $update->updateProfile();
            var_dump($update->getErrors());
            $this->index();
        }else{

        }
    }

}