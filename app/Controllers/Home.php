<?php

namespace Controllers;

use Core\Controller;

class Home extends Controller
{
    public function index()
    {
        echo $this->view->render('Home/index.phtml');
    }

    public function number()
    {
        $numberOfImages = \Models\Gallery::getNumberOfImages();
        echo 'Number of images: ' . count($numberOfImages);
    }
}