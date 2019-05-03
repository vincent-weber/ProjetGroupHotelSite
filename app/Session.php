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

    public static function unset($variable = null){
        if($variable == null){
            session_unset();
        }
        else
        {
            unset($_SESSION[$variable]);
        }
    }
}