<?php


namespace Includes;


class Hash
{
    private $token;

    public static function make($string)
    {
        return hash('sha256', $string);
    }

    public static function salt($lenght)
    {
        return mcrypt_create_iv($lenght);
    }

    public static function unique()
    {
        return self::make(uniqid());
    }
}