<?php

include_once ROOT . '/tools/resources/UserResource.php';
require_once ROOT . '/tools/validators/UserValidator.php';
require_once ROOT . '/repository/UserRepository.php';

class RegisterModel {

    private $data = null;
    private $validator;

    public function __construct() {
        $this->validator = new UserValidator();

        if (isset(
            $_POST[LOGIN_TAG],
            $_POST[EMAIL_TAG],
            $_POST[PASSWORD_TAG],
            $_POST[RE_PASSWORD_TAG],
            $_POST[FIRST_NAME_TAG],
            $_POST[SECOND_NAME_TAG],
            $_POST[REGISTER_SUBMIT_TAG],
            $_FILES[PHOTO_TAG]
        )) {
            $this->data = array(
                LOGIN_TAG => trim($_POST[LOGIN_TAG]),
                EMAIL_TAG => trim($_POST[EMAIL_TAG]),
                PASSWORD_TAG => $_POST[PASSWORD_TAG],
                RE_PASSWORD_TAG => $_POST[RE_PASSWORD_TAG],
                FIRST_NAME_TAG => trim($_POST[FIRST_NAME_TAG]),
                SECOND_NAME_TAG => trim($_POST[SECOND_NAME_TAG]),
                LAST_NAME_TAG => trim($_POST[LAST_NAME_TAG]),
                PHOTO_TAG => $_FILES[PHOTO_TAG]
            );

            if (empty($_FILES[PHOTO_TAG]['name']) && !empty($_SESSION[PHOTO_TAG]['name'])) {
                $this->data[PHOTO_TAG] = $_SESSION[PHOTO_TAG]['name'];
            } else if (empty($_FILES[PHOTO_TAG]['name'])) {
                $this->data[PHOTO_TAG] = null;
            }

            $_SESSION[PHOTO_TAG] = null;
            $_SESSION[REGISTER_SESSION_TAG] = $this->data;
        }
    }

    public function register($success, $failed) {
        if (UserRepository::create($this->data))
            $this->provideMessage($success, SUCCESS_TAG);
        $this->provideMessage($failed, ERROR_TAG);
    }

    public function validPOST(): bool { return isset($this->data); }

    public function validLogin(): int { return $this->validator->isLoginValid($this->data[LOGIN_TAG]); }
    public function validEmail(): int { return $this->validator->isEmailValid($this->data[EMAIL_TAG]); }
    public function validPasswords(): int { return $this->validator->isPasswordsValid($this->data[PASSWORD_TAG], $this->data[RE_PASSWORD_TAG]); }
    public function validFirstName(): int { return $this->validator->isNameValid($this->data[FIRST_NAME_TAG]); }
    public function validSecondName(): int { return $this->validator->isNameValid($this->data[SECOND_NAME_TAG]); }
    public function validLastName(): int { return $this->validator->isNameValidOrNull($this->data[LAST_NAME_TAG]); }
    public function validPhoto(): int { return $this->validator->isPhotoValid($this->data[PHOTO_TAG]); }

    public function provideMessage($message, $tag) {
        $fragment = parse_url($_SERVER['HTTP_REFERER']);
        $url = $fragment['scheme'].'://'.$fragment['host'].''.$fragment['path'];

        $_SESSION[REGISTER_SESSION_TAG][$tag] = $message;

        header('Location: '.$url);
        exit();
    }
}