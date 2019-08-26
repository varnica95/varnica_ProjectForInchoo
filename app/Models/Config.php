<?php

namespace Models;

class Config{
    private static $_instance;
    private $_config;

    private function __construct()
    {
       $this->_config = require '../app/Core/environment.php';
    }

    public function getConfig($path = null)
    {
        $temp = $this->_config;
        if ($path) {
            $path = explode("/", $path);
            foreach ($path as $part) {
                if (isset($temp[$part]))
                    $temp = $temp[$part];
            }
            return $temp;
        }
    }
    public static function getInstance()
    {
        if(!isset(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}