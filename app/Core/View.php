<?php

namespace Core;

class View
{
    protected $view_file,
        $view_data;

    public function __construct($view_file, $view_data)
    {
        $this->view_file = $view_file;
        $this->view_data = $view_data;
    }

    public function render($templateFile, array $vars = [])
    {
//        if (file_exists('../app/Views/' . $this->view_file . '.phtml')) {
//            require '../app/Views/' . $this->view_file . '.phtml';
//        }
        if (file_exists(BP . '/app/Views/' . $templateFile)) {
            ob_start();
            try {
                extract($vars, EXTR_SKIP);
                include  BP . '/app/Views/' . $templateFile;
            } catch (\Exception $e) {
                ob_end_clean();
                throw $e;
            }
        }

        $output = ob_get_clean();

        return $output;
    }
}