<?php

include_once ROOT . '/tools/resources/UserResource.php';
require_once ROOT . '/tools/validators/UserValidator.php';
require_once ROOT . '/repository/UserRepository.php';
require_once ROOT . '/repository/ProfileRepository.php';

class LoginModel
{

    private $data = null;
    private $validator;

    public function __construct()
    {
        $this->validator = new UserValidator();

        if (isset(
            $_POST[LOGIN_TAG],
            $_POST[PASSWORD_TAG],
            $_POST[LOGIN_SUBMIT_TAG]
        )) {
            $this->data = array(
                LOGIN_TAG => trim($_POST[LOGIN_TAG]),
                PASSWORD_TAG => $_POST[PASSWORD_TAG]
            );

            $_SESSION[LOGIN_SESSION_TAG] = $this->data;
        }
    }

    public function login($location, $failed)
    {
        $user = UserRepository::get($this->data[LOGIN_TAG]);

        if ($user !== false && $user[PASSWORD_TAG] === md5(md5($this->data[LOGIN_TAG]) . md5($this->data[PASSWORD_TAG]))) {
            $this->setUserEnvironment($user);
            $this->provideMessage($location, SUCCESS_TAG);
        } else {
            $this->provideMessage($failed, ERROR_TAG);
        }
    }

    public function validPOST(): bool
    {
        return isset($this->data);
    }

    public function validLogin(): int
    {
        $result = $this->validator->isLoginValid($this->data[LOGIN_TAG]);
        if ($result === UserValidator::$LOGIN_RESERVED_ERROR)
            $result = UserValidator::$SUCCESS;
        return $result;
    }

    public function validPassword(): int
    {
        return $this->validator->isPasswordValid($this->data[PASSWORD_TAG]);
    }

    public function provideMessage($message, $tag)
    {
        $fragment = parse_url($_SERVER['HTTP_REFERER']);
        $url = $fragment['scheme'] . '://' . $fragment['host'];

        switch ($tag) {
            case ERROR_TAG:
                $_SESSION[LOGIN_SESSION_TAG][ERROR_TAG] = $message;
                header('Location: ' . $url . $fragment['path']);
                break;
            case SUCCESS_TAG:
                header('Location: /' . $message);
                break;
        }

        exit();
    }

    private function setUserEnvironment($user)
    {
        unset($user[PASSWORD_TAG]);
        unset($user[RESET_VALUE_TAG]);
        unset($user[RESET_DATE_TAG]);

        ProfileRepository::set($user);

        setcookie(LOGIN_TAG, $this->data[LOGIN_TAG], time() + 60 * 60 * 24 * 30, '/');
        setcookie(HASH_TAG, md5(md5(md5($this->data[LOGIN_TAG]) . md5($this->data[PASSWORD_TAG])) . md5($_SERVER['REMOTE_ADDR'])), time() + 60 * 60 * 24 * 30, '/');
    }

}