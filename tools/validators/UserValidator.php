<?php

require_once ROOT . '/repository/UserRepository.php';
require_once ROOT . '/repository/ProfileRepository.php';

class UserValidator
{

    public static $SUCCESS = 0x00000;

    public static $LOGIN_EMPTY_ERROR = 0x00001;
    public static $LOGIN_LENGTH_ERROR = 0x00002;
    public static $LOGIN_CHARACTERS_ERROR = 0x00003;
    public static $LOGIN_RESERVED_ERROR = 0x00004;

    public static $EMAIL_EMPTY_ERROR = 0x00010;
    public static $EMAIL_LENGTH_ERROR = 0x00020;
    public static $EMAIL_VALID_ERROR = 0x00030;
    public static $EMAIL_RESERVED_ERROR = 0x00040;

    public static $PASSWORDS_EMPTY_ERROR = 0x00100;
    public static $PASSWORD_LENGTH_ERROR = 0x00200;
    public static $PASSWORDS_NOT_SAME_ERROR = 0x00300;
    public static $PASSWORDS_NOT_CONFIRM_ERROR = 0x00400;

    public static $NAME_EMPTY_ERROR = 0x01000;
    public static $NAME_LENGTH_ERROR = 0x02000;
    public static $NAME_CHARACTERS_ERROR = 0x03000;

    public static $PHOTO_EXT_ERROR = 0x10000;
    public static $PHOTO_LOAD_ERROR = 0x20000;
    public static $PHOTO_SIZE_ERROR = 0x30000;

    public function isLoginValid($login): int
    {
        if (empty($login))
            return UserValidator::$LOGIN_EMPTY_ERROR;
        if (strlen($login) < 3 || strlen($login) > 256)
            return UserValidator::$LOGIN_LENGTH_ERROR;
        if (preg_match("/\\s/", $login))
            return UserValidator::$LOGIN_CHARACTERS_ERROR;
        if (UserRepository::isLoginReserved($login))
            return UserValidator::$LOGIN_RESERVED_ERROR;

        return UserValidator::$SUCCESS;
    }

    public function isEmailValid($email): int
    {
        if (empty($email))
            return UserValidator::$EMAIL_EMPTY_ERROR;
        if (strlen($email) < 3 || strlen($email) > 512)
            return UserValidator::$EMAIL_LENGTH_ERROR;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return UserValidator::$EMAIL_VALID_ERROR;
        if (UserRepository::isEmailReserved($email))
            return UserValidator::$EMAIL_RESERVED_ERROR;

        return UserValidator::$SUCCESS;
    }

    public function isPasswordsValid($password, $rePassword): int
    {
        $passwordValidate = $this->isPasswordValid($password);
        if ($passwordValidate != UserValidator::$SUCCESS)
            return $passwordValidate;
        if ($password !== $rePassword)
            return UserValidator::$PASSWORDS_NOT_SAME_ERROR;

        return UserValidator::$SUCCESS;
    }

    public function isPasswordValid($password): int
    {
        if (empty($password))
            return UserValidator::$PASSWORDS_EMPTY_ERROR;
        if (strlen($password) < 3)
            return UserValidator::$PASSWORD_LENGTH_ERROR;

        return UserValidator::$SUCCESS;
    }

    public function isPasswordConfirm($login, $password): int
    {
        $result = $this->isPasswordValid($password);
        if ($result !== UserValidator::$SUCCESS)
            return $result;
        if (md5(md5($login) . md5($password)) !== ProfileRepository::get(PASSWORD_TAG))
            return UserValidator::$PASSWORDS_NOT_CONFIRM_ERROR;
        return UserValidator::$SUCCESS;
    }

    public function isNameValid($name): int
    {
        if (empty($name))
            return UserValidator::$NAME_EMPTY_ERROR;

        return $this->isNameValidOrNull($name);
    }

    public function isNameValidOrNull($name): int
    {
        if (empty($name))
            return UserValidator::$SUCCESS;
        if (strlen($name) < 3 || strlen($name) > 256)
            return UserValidator::$NAME_LENGTH_ERROR;
        if (!preg_match("/^[a-zA-Zа-яА-Я]+$/", $name))
            return UserValidator::$NAME_CHARACTERS_ERROR;

        return UserValidator::$SUCCESS;
    }

    public function isPhotoValid($photo): int
    {
        if (!isset($photo) || empty($photo['name']))
            return UserValidator::$SUCCESS;

        $allowed = array('png', 'jpg', 'jpeg', 'gif');
        $fileExt = explode('.', $photo['name']);
        $fileActualExt = strtolower(end($fileExt));

        if (!in_array($fileActualExt, $allowed))
            return UserValidator::$PHOTO_EXT_ERROR;
        if ($photo['error'] !== 0)
            return UserValidator::$PHOTO_LOAD_ERROR;
        if ($photo['size'] > 5 * 1024 * 1024) // 5mb
            return UserValidator::$PHOTO_SIZE_ERROR;

        return UserValidator::$SUCCESS;
    }
}