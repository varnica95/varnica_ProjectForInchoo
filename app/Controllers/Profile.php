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
        echo $this->view->render('Profile/index.phtml');
    }

    public function update()
    {
        if (isset($_POST['update-submit'])) {
            $validation = new ProfileValidation($_POST);
            if ($validation->getPass()) {
                $profile = new User($_POST);

                $profile->updatePassword();

                if (!empty($profile->getErrors())) {
                    $this->_error = $profile->getErrors();
                    echo $this->view->render('Profile/index.phtml', [
                        'curPwError' => $this->_error
                    ]);
                } else {
                    echo $this->view->render('Profile/index.phtml', [
                        'pwsuccess' => 'The password updated successfully.'
                    ]);
                }

            } else {
                echo $this->view->render('Profile/index.phtml', [
                    'errors' => $validation->getErrors(),
                    'pwerror' => $this->_error
                ]);

            }
        }
    }

    public function delete()
    {
        if (isset($_POST['delete-submit'])) {
            $images = Gallery::getImageNames();
            foreach ($images as $key => $value) {
                unlink(BP . '/public/img/' . $value->getData()['imgFullNameGallery']);
            }
            User::deleteAccount();
            $this->view('login' . DIRECTORY_SEPARATOR . 'index');
            echo $this->view->render('Login/index.phtml', [
                'success' => 'The account is deleted successfully.'
            ]);

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
                $fileTempName = $file["tmp_name"];
                $fileError = $file["error"];

                $fileExt = explode(".", $fileName);
                $fileActualExt = strtolower(end($fileExt));
                $allowed = array("jpg", "jpeg", "png");

                if (in_array($fileActualExt, $allowed)) {
                    if ($fileError === 0) {
                        $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
                        $fileDestination = BP . '/public/img/' . $imageFullName;
                        $info = new User();
                        $uploader = $info->getUsername();

                        $image = new Gallery(Session::get('id'), $uploader, $imageTitle, $imageDesc, $imageFullName);
                        $image->uploadImage();
                        move_uploaded_file($fileTempName, $fileDestination);
                        $this->view('profile' . DIRECTORY_SEPARATOR . 'index');
                        echo $this->view->render('Profile/index.phtml', [
                            'imgsuccess' => 'Image uploaded successfully.'
                        ]);
                    }
                } else {
                    $this->view('profile' . DIRECTORY_SEPARATOR . 'index');
                    echo $this->view->render('Profile/index.phtml', [
                        'fileerror' => 'The file does not exist or the extension is not allowed. Please try again.'
                    ]);
                }

            } else {
                $this->view('profile' . DIRECTORY_SEPARATOR . 'index');
                echo $this->view->render('Profile/index.phtml', [
                    'fileerrors' => $validation->getErrors()
                ]);
            }
        }
    }
}