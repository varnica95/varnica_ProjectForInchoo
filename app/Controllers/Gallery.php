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

    }

    public function user($uploader)
    {
        $gallery = \Models\Gallery::getUserGallery($uploader);

        $this->view('Gallery' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Gallery/index.phtml', [
           'gallery' => $gallery
        ]);
    }

    public function delete($uploaderid, $imgname)
    {
        $gallery = \Models\Gallery::deleteImage($uploaderid);
        unlink( BP . '/public/img/'. $imgname);
        $this->index();
    }


}