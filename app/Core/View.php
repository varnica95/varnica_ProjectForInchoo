<?php

namespace Core;

class View
{
    protected $view_file;
    protected $view_data;

    public function __construct()
    {

    }

    public function render($templateFile, array $vars = [])
    {
        if (file_exists(BP . '/app/Views/' . $templateFile)) {
            ob_start();
            try {
                extract($vars, EXTR_SKIP);
                include BP . '/app/Views/' . $templateFile;
            } catch (\Exception $e) {
                ob_end_clean();
                throw $e;
            }
        }

        $output = ob_get_clean();

        return $output;
    }
}