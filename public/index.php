<?php

//Autoloading every .php file
use Models\Config;

spl_autoload_register(function($class) {
    $file = str_replace('\\', '/', $class);
    echo $file, '<br>';
    require_once '../app/' .$file . '.php';
});

$a = Models\Database::getInstance()->query('SELECT * FROM users WHERE id = ?', array('2'));
//var_dump($a);

//foreach ($a->result() as $user)
//{
//    echo $user->name;
//}

echo $a->result()->name;