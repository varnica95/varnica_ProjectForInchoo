<?php

if (!isset($_SESSION))
    session_start();

define('BP', dirname(__DIR__));

use Models\Config;
use Models\Session;

spl_autoload_register(function ($class) {

    $file = str_replace('\\', '/', $class);
    $path = BP . '/app/' . $file . '.php';

    if (file_exists($path)) {
        require_once $path;
    }
    else{
        echo "Error: File not found.";
    }

});


$router = new \Core\Router();
$router->run();

if (\Models\Cookie::exists(Config::getInstance()->getConfig("remember/cookie_name")) && !$_SESSION) {
    $hash = \Models\Cookie::get(Config::getInstance()->getConfig("remember/cookie_name"));
    $hashCheck = \Models\User::CheckHashRememberme($hash);

    if (!empty($hashCheck)) {
        Session::start();
        Session::set('id', $hashCheck->user_id);
    }
}
