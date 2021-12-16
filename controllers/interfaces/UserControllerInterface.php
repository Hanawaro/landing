<?php

require_once ROOT . '/controllers/interfaces/SecurityControllerInterface.php';

class UserControllerInterface extends SecurityControllerInterface
{

    private $login = null;
    private $register = null;
    private $resetPassword = null;
    private $update = null;

    public function __construct()
    {
        parent::__construct();

        if (isset($_SESSION[LOGIN_SESSION_TAG])) {
            $this->login = $_SESSION[LOGIN_SESSION_TAG];
            unset($_SESSION[LOGIN_SESSION_TAG]);
        }

        if (isset($_SESSION[REGISTER_SESSION_TAG])) {
            $this->register = $_SESSION[REGISTER_SESSION_TAG];
            $_SESSION[PHOTO_TAG] = $this->register[PHOTO_TAG];
            unset($_SESSION[REGISTER_SESSION_TAG]);
        } else {
            unset($_SESSION[PHOTO_TAG]);
        }

        if (isset($_SESSION[RESET_PASSWORD_SESSION_TAG])) {
            $this->resetPassword = $_SESSION[RESET_PASSWORD_SESSION_TAG];
            unset($_SESSION[RESET_PASSWORD_SESSION_TAG]);
        }

        if (isset($_SESSION[UPDATE_SESSION_TAG])) {
            $this->update = $_SESSION[UPDATE_SESSION_TAG];
            unset($_SESSION[UPDATE_SESSION_TAG]);
        }

    }

    public function isTryLogin(): bool
    {
        return isset($this->login);
    }

    public function isTryRegister(): bool
    {
        return isset($this->register);
    }

    public function isTryResetPassword(): bool
    {
        return isset($this->resetPassword);
    }

    public function isTryUpdate(): bool
    {
        return isset($this->update);
    }

    public function getLogin($key): string
    {
        if ($this->isTryLogin() && isset($this->login[$key]))
            return htmlspecialchars($this->login[$key]);
        return '';
    }

    public function getRegister($key): string
    {
        if ($this->isTryRegister() && isset($this->register[$key]) && (!isset($this->register[SUCCESS_TAG]) || $key === SUCCESS_TAG))
            return htmlspecialchars($this->register[$key]);
        return '';
    }

    public function getResetPassword($key): string
    {
        if ($this->isTryResetPassword() && isset($this->resetPassword[$key]))
            return htmlspecialchars($this->resetPassword[$key]);
        return '';
    }

    public function getUpdate($key)
    {
        if ($this->isTryUpdate() && isset($this->update[$key]))
            return htmlspecialchars($this->update[$key]);
        return '';
    }
}