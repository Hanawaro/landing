<?php

require_once ROOT . '/repository/UserRepository.php';
require_once ROOT . '/repository/ProfileRepository.php';
require_once ROOT . '/tools/resources/UserResource.php';

class SecurityControllerInterface
{

    public function __construct()
    {
        if (isset($_COOKIE[LOGIN_TAG], $_COOKIE[HASH_TAG])) {
            $user = UserRepository::get($_COOKIE[LOGIN_TAG]);
            if ($user !== false) {
                $hash = md5($user[PASSWORD_TAG] . md5($_SERVER['REMOTE_ADDR']));
                if ($hash === $_COOKIE[HASH_TAG])
                    ProfileRepository::set($user);
            }
        }
    }

    public function require()
    {
        if (!$this->isRequired()) {
            $this->redirect();
        }
    }

    public function redirect()
    {
        $protocol = $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
        $hostname = $_SERVER['HTTP_HOST'];
        $url = $protocol . $hostname;
        header('Location: ' . $url);
    }

    public function isRequired(): bool
    {
        return ProfileRepository::exist();
    }
}