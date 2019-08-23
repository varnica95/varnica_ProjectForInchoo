<?php


namespace Controllers;


use Core\Controller;

class Gallery extends Controller
{
    private $_gallery;

    public function index()
    {
        $this->_gallery = \Models\Gallery::getGallery();
        $this->view('gallery' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Gallery/index.phtml', [
            'gallery' => $this->_gallery
        ]);

    }

    public function user($uploader)
    {
        $gallery = \Models\Gallery::getUserGallery($uploader);

        $this->view('gallery' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Gallery/index.phtml', [
            'gallery' => $gallery
        ]);
    }

    public function delete($id, $imgname)
    {
        $gallery = \Models\Gallery::deleteImage($id);
        $this->_gallery = \Models\Gallery::getGallery();
        unlink(BP . '/public/img/' . $imgname);
        $this->view('gallery' . DIRECTORY_SEPARATOR . 'index');
        echo $this->view->render('Gallery/index.phtml', [
            'success' => 'The image deleted successfully.',
            'gallery' => $this->_gallery
        ]);
    }

    public function update($title = [], $desc = [], $id)
    {
        $t = str_replace(".!.", " ", $title);
        $d = str_replace(".!.", " ", $desc);

        $update = \Models\Gallery::updateRow($t, $d, $id);

    }

}