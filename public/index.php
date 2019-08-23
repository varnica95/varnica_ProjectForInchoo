<?php

if (!isset($_SESSION))
    session_start();

define('BP', dirname(__DIR__));

use Models\Config;
use Models\Session;

spl_autoload_register(function ($class) {
    $file = str_replace('\\', '/', $class);
    require_once BP . '/app/' . $file . '.php';
});


new \Core\Router();

if (\Models\Cookie::exists(Config::getInstance()->getConfig("remember/cookie_name")) && !$_SESSION) {
    $hash = \Models\Cookie::get(Config::getInstance()->getConfig("remember/cookie_name"));
    $hashCheck = \Models\User::CheckHashRememberme($hash);

    if (!empty($hashCheck)) {
        Session::start();
        Session::set('id', $hashCheck->user_id);
    }
}
