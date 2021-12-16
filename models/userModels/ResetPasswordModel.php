<?php

include_once ROOT . '/tools/resources/UserResource.php';
require_once ROOT . '/tools/validators/UserValidator.php';
require_once ROOT . '/repository/UserRepository.php';

class ResetPasswordModel
{
    private $data = null;
    private $validator;

    public function __construct()
    {
        $this->validator = new UserValidator();

        if (isset(
            $_POST[LOGIN_TAG],
            $_POST[RESET_VALUE_TAG],
            $_POST[PASSWORD_TAG],
            $_POST[RE_PASSWORD_TAG],
            $_POST[RESET_PASSWORD_SUBMIT_TAG]
        )) {
            $this->data = array(
                LOGIN_TAG => trim($_POST[LOGIN_TAG]),
                RESET_VALUE_TAG => trim($_POST[RESET_VALUE_TAG]),
                PASSWORD_TAG => $_POST[PASSWORD_TAG],
                RE_PASSWORD_TAG => $_POST[RE_PASSWORD_TAG]
            );

            $_SESSION[RESET_PASSWORD_SESSION_TAG] = $this->data;
        } else if (isset(
            $_POST[LOGIN_TAG],
            $_POST[RESET_PASSWORD_SUBMIT_TAG]
        )) {
            $this->data = array(
                LOGIN_TAG => trim($_POST[LOGIN_TAG]),
            );

            $_SESSION[RESET_PASSWORD_SESSION_TAG] = $this->data;
        }
    }

    public function reset($success, $failed)
    {
        $user = UserRepository::get($this->data[LOGIN_TAG]);

        if ($user !== false && $this->validToken($this->data[LOGIN_TAG], $this->data[RESET_VALUE_TAG])) {
            if ($this->updatePassword($user)) {
                $this->provideMessage($success, SUCCESS_TAG);
                return;
            }
        }
        $this->provideMessage($failed, ERROR_TAG);
    }

    public function send($success)
    {
        $user = UserRepository::get($this->data[LOGIN_TAG]);

        if ($user !== false) {
            if ($this->sendEmail($user)) {

                $protocol = $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
                $hostname = $_SERVER['HTTP_HOST'];
                $url = $protocol . $hostname . '/user/reset-password/' . $user[LOGIN_TAG] . '/' . $user[RESET_VALUE_TAG];

                $this->provideMessage($url, SUCCESS_TAG);
                return;
            }
        }
        $this->provideMessage($success, SUCCESS_TAG);
    }

    public function validToken($login, $token): bool
    {

        $user = UserRepository::get($login);

        if ($user !== false) {
            $userToken = $user[RESET_VALUE_TAG];
            $userTokenDate = date($user[RESET_DATE_TAG]);

            $now = new DateTime(date('Y-m-d H:i:s'));
            $fromToken = new DateTime($userTokenDate);

            return $userToken === $token && date_diff($now, $fromToken)->h < 2;
        }

        return false;
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

    public function validPasswords(): int
    {
        return $this->validator->isPasswordsValid($this->data[PASSWORD_TAG], $this->data[RE_PASSWORD_TAG]);
    }

    public function provideMessage($message, $tag)
    {
        $fragment = parse_url($_SERVER['HTTP_REFERER']);
        $url = $fragment['scheme'] . '://' . $fragment['host'] . '' . $fragment['path'];

        $_SESSION[RESET_PASSWORD_SESSION_TAG][$tag] = $message;

        header('Location: ' . $url);
        exit();
    }

    private function sendEmail(&$user): bool
    {
        $user[RESET_VALUE_TAG] = uniqid();
        $user[RESET_DATE_TAG] = date('Y-m-d H:i:s');

        return UserRepository::update($user);
    }

    private function updatePassword(&$user): bool
    {
        $user[PASSWORD_TAG] = md5(md5($user[LOGIN_TAG]) . md5($this->data[PASSWORD_TAG]));
        $user[RESET_VALUE_TAG] = null;

        return UserRepository::update($user);;
    }
}