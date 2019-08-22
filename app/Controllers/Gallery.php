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

    public function delete($id, $imgname)
    {
        $gallery = \Models\Gallery::deleteImage($id);
        unlink( BP . '/public/img/'. $imgname);
        $this->view('Gallery' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Gallery/index.phtml', [
            'success' => 'Image deleted successfully.'
        ]);
    }

    public function update($title, $desc, $id)
    {
        $update = \Models\Gallery::updateRow($title, $desc, $id);

        echo $title;
    }

}