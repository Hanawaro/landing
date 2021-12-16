<?php

include_once ROOT . '/tools/resources/UserResource.php';

class ProfileRepository
{
    private const SESSION_NAME = 'profile';

    public static function set($user)
    {
        $_SESSION[self::SESSION_NAME] = $user;
    }

    public static function unset()
    {
        unset($_SESSION[self::SESSION_NAME]);
    }

    public static function get($key)
    {
        return $_SESSION[self::SESSION_NAME][$key];
    }

    public static function exist()
    {
        return isset($_SESSION[self::SESSION_NAME]);
    }
}