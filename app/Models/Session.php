<?php


namespace Models;


class Session
{
    public static function start()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    public static function set($name, $key)
    {
        $_SESSION[$name] = $key;
    }

    public static function destroy()
    {
        if (!isset($_SESSION))
        session_start();

        session_unset();

        session_destroy();
    }

    public static function get($key)
    {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }
}