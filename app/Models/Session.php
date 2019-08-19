<?php


namespace Models;


class Session
{
    public static function start()
    {
        if (!isset($_SESSION))
        session_start();
    }
    public static function set($name, $key)
    {
       // foreach ($k as $key => $value)
        $_SESSION[$name] = $key;
    }

    public static function destroy()
    {
        session_start();
        session_unset();

        session_destroy();
    }

    public static function get($key)
    {
        return $_SESSION[$key];
    }




}