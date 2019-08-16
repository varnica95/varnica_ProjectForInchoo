<?php


namespace Models;


class Session
{
    public static function start()
    {
        session_start();
    }
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function destroy()
    {
        session_start();
        session_unset();

        session_destroy();
    }




}