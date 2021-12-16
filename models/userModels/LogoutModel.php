<?php

require_once ROOT . '/repository/ProfileRepository.php';

class LogoutModel
{
    public function logout()
    {

        ProfileRepository::unset();
        setcookie(LOGIN_TAG, null, 0, '/');
        setcookie(HASH_TAG, null, 0, '/');

        $protocol = $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
        $hostname = $_SERVER['HTTP_HOST'];
        $url = $protocol . $hostname;
        header('Location: ' . $url);
    }
}