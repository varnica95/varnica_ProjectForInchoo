<?php

namespace Models;

class Config{
    private static $_instance = NULL;
    private $_config;

    private function __construct(){}

    public function getConfig($path = null)
    {
        $this->_config = require '../app/Core/environment.php';
        if ($path) {
            $path = explode("/", $path);
            foreach ($path as $part) {
                if (isset($this->_config[$part]))
                    $this->_config = $this->_config[$part];
            }
            return $this->_config;
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
    public function ConfigToSting()
    {
        return $this->_config;
    }
}