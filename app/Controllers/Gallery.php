<?php


namespace Controllers;


use Core\Controller;

class Gallery extends Controller
{
    public function index()
    {
        $gallery = \Models\Gallery::getGallery();

        $this->view('Gallery' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Gallery/index.phtml', [
            'gallery' => $gallery
        ]);

        var_dump($gallery);
    }

}