<?php


class Session{


    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function put($key, $value)
    {
        $_SESSION[$key] = serialize($value);
    }


    public static function get($key){
        if( isset($_SESSION[$key]))
            return unserialize($_SESSION[$key]);
    }
}