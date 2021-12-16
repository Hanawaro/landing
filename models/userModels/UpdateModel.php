<?php

include_once ROOT . '/tools/resources/UserResource.php';
require_once ROOT . '/tools/validators/UserValidator.php';
require_once ROOT . '/repository/UserRepository.php';

class UpdateModel
{

    private $data = null;
    private $validator;

    public function __construct()
    {
        $this->validator = new UserValidator();

        if (isset(
            $_POST[UPDATE_SUBMIT_TAG]
        )) {

            $this->data = array(
                LOGIN_TAG => ProfileRepository::get(LOGIN_TAG),
                EMAIL_TAG => trim($_POST[EMAIL_TAG] ?? ProfileRepository::get(EMAIL_TAG)),
                OLD_PASSWORD_TAG => $_POST[OLD_PASSWORD_TAG] ?? null,
                PASSWORD_TAG => $_POST[PASSWORD_TAG] ?? ProfileRepository::get(PASSWORD_TAG),
                RE_PASSWORD_TAG => $_POST[RE_PASSWORD_TAG] ?? ProfileRepository::get(PASSWORD_TAG),
                FIRST_NAME_TAG => trim($_POST[FIRST_NAME_TAG] ?? ProfileRepository::get(FIRST_NAME_TAG)),
                SECOND_NAME_TAG => trim($_POST[SECOND_NAME_TAG] ?? ProfileRepository::get(SECOND_NAME_TAG)),
                LAST_NAME_TAG => trim($_POST[LAST_NAME_TAG] ?? ProfileRepository::get(LAST_NAME_TAG)),
                PHOTO_TAG => $_FILES[PHOTO_TAG] ?? null
            );

            if (empty($_FILES[PHOTO_TAG]['name'])) {
                $this->data[PHOTO_TAG] = ProfileRepository::get(PHOTO_TAG);
            }

            $_SESSION[UPDATE_SESSION_TAG] = $this->data;
        }
    }

    public function update($success, $failed)
    {
        $user = UserRepository::get($this->data[LOGIN_TAG]);

        if ($user !== false) {

            if (isset($this->data[OLD_PASSWORD_TAG])) {
                $this->data[PASSWORD_TAG] = md5(md5($this->data[LOGIN_TAG]) . md5($this->data[PASSWORD_TAG]));
            }

            if (UserRepository::update($this->data)) {
                $_SESSION[UPDATE_SESSION_TAG][PHOTO_TAG] = ProfileRepository::get(PHOTO_TAG);
                $this->provideMessage($success, SUCCESS_TAG);
                return;
            }
        }
        $this->provideMessage($failed, ERROR_TAG);
    }

    public function validPOST(): bool
    {
        return isset($this->data);
    }


    public function validEmail(): int
    {
        if ($this->data[EMAIL_TAG] === ProfileRepository::get(EMAIL_TAG))
            return UserValidator::$SUCCESS;
        return $this->validator->isEmailValid($this->data[EMAIL_TAG]);;
    }

    public function validPasswords(): int
    {
        if (isset($this->data[OLD_PASSWORD_TAG])) {
            $confirm = $this->validator->isPasswordConfirm($this->data[LOGIN_TAG], $this->data[OLD_PASSWORD_TAG]);
            if ($confirm !== UserValidator::$SUCCESS)
                return $confirm;
        }
        return $this->validator->isPasswordsValid($this->data[PASSWORD_TAG], $this->data[RE_PASSWORD_TAG]);
    }

    public function validFirstName(): int
    {
        return $this->validator->isNameValid($this->data[FIRST_NAME_TAG]);
    }

    public function validSecondName(): int
    {
        return $this->validator->isNameValid($this->data[SECOND_NAME_TAG]);
    }

    public function validLastName(): int
    {
        return $this->validator->isNameValidOrNull($this->data[LAST_NAME_TAG]);
    }

    public function validPhoto(): int
    {
        return $this->validator->isPhotoValid($this->data[PHOTO_TAG]);
    }

    public function provideMessage($message, $tag)
    {
        $fragment = parse_url($_SERVER['HTTP_REFERER']);
        $url = $fragment['scheme'] . '://' . $fragment['host'] . '' . $fragment['path'];

        $_SESSION[UPDATE_SESSION_TAG][$tag] = $message;

        header('Location: ' . $url);
        exit();
    }
}