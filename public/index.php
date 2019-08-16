<?php

use Models\Config;

spl_autoload_register(function($class) {
    $file = str_replace('\\', '/', $class);
    require_once '../app/' .$file . '.php';
});



new \Core\Router();

$a = Models\Database::getInstance()->query('SELECT * FROM users WHERE id = ?', array('2'));
//var_dump($a);

//foreach ($a->result() as $user)
//{
//    echo $user->name;
//}
