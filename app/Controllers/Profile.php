<?php

namespace Controllers;

use Core\Controller;
use Includes\ImageValidation;
use Includes\ProfileValidation;
use Models\Gallery;
use Models\Session;
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

    public function upload()
    {
        if (isset($_POST['upload-submit'])) {
            $validation = new ImageValidation($_POST);

            if ($validation->getPass()) {

                $newFileName = $_POST['filename'];
                $imageTitle = $_POST['filetitle'];
                $imageDesc = $_POST['filedesc'];

                $file = $_FILES['file'];

                $fileName = $file["name"];
                $fileType = $file["type"];
                $fileTempName = $file["tmp_name"];
                $fileError = $file["error"];
                $fileSize = $file["size"];

                $fileExt = explode(".", $fileName);
                $fileActualExt = strtolower(end($fileExt));
                $allowed = array("jpg", "jpeg", "png");

                if (in_array($fileActualExt, $allowed)) {
                    if ($fileError === 0) {
                        if ($fileSize < 2000000){
                            $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
                            $fileDestination = BP . '/public/img/' . $imageFullName;
                            $info = new User();
                            $uploader = $info->getUsername();

                            $image = new Gallery(Session::get('id'), $uploader->username, $imageTitle, $imageDesc, $imageFullName);
                            $image->uploadImage();
                            move_uploaded_file($fileTempName, $fileDestination);
                            $this->index();
                        }else{
                            echo 'filesize too long';
                        }
                    }else{
                        echo "You had an error.";
                    }
                }


                }
            }
    }
}