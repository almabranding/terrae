<?php

class Session
{
    
    public static function init()
    {
        @session_start();
    }
    
    public static function set($key, $value)
    {
        $_SESSION['intra'][$key] = $value;
    }
    
    public static function get($key)
    {
        if (isset($_SESSION['intra'][$key]))
        return $_SESSION['intra'][$key];
    }
    
    public static function destroy()
    {
        //unset($_SESSION);
        session_destroy();
    }
    
}