<?php

require_once ROOT . '/models/userModels/LoginModel.php';
require_once ROOT . '/models/userModels/RegisterModel.php';
require_once ROOT . '/models/userModels/ResetPasswordModel.php';
require_once ROOT . '/models/userModels/LogoutModel.php';
require_once ROOT . '/models/userModels/UpdateModel.php';

require_once 'interfaces/UserControllerInterface.php';

class UserController extends UserControllerInterface
{
    // reset page action

    public function actionLoadResetPage($login, $token)
    {

        $resetPasswordModel = new ResetPasswordModel();

        if (!$resetPasswordModel->validToken($login, $token) && !$this->isTryResetPassword()) {
            $this->redirect();
            exit;
        }
        require_once(ROOT . '/views/reset-password/reset-password.php');
    }

    // user management actions

    public function actionUpdate()
    {
        $updateModel = new UpdateModel();

        if (!$updateModel->validPOST()) {
            $updateModel->provideMessage("Invalid request", ERROR_TAG);
            return;
        }
        switch ($updateModel->validEmail()) {
            case UserValidator::$EMAIL_EMPTY_ERROR:
                $updateModel->provideMessage("Email should not be empty", ERROR_TAG);
                return;
            case UserValidator::$EMAIL_LENGTH_ERROR:
                $updateModel->provideMessage("Login must be between 3 and 512 characters long", ERROR_TAG);
                return;
            case UserValidator::$EMAIL_VALID_ERROR:
                $updateModel->provideMessage("Incorrect email", ERROR_TAG);
                return;
            case UserValidator::$EMAIL_RESERVED_ERROR:
                $updateModel->provideMessage("Email has been reserved already", ERROR_TAG);
                return;
        }

        switch ($updateModel->validFirstName()) {
            case UserValidator::$NAME_EMPTY_ERROR:
                $updateModel->provideMessage("First name should not be empty", ERROR_TAG);
                return;
            case UserValidator::$NAME_LENGTH_ERROR:
                $updateModel->provideMessage("First name must be between 3 and 256 characters long", ERROR_TAG);
                return;
            case UserValidator::$NAME_CHARACTERS_ERROR:
                $updateModel->provideMessage("Incorrect first name", ERROR_TAG);
                return;
        }

        switch ($updateModel->validSecondName()) {
            case UserValidator::$NAME_EMPTY_ERROR:
                $updateModel->provideMessage("Second name should not be empty", ERROR_TAG);
                return;
            case UserValidator::$NAME_LENGTH_ERROR:
                $updateModel->provideMessage("Second name must be between 3 and 256 characters long", ERROR_TAG);
                return;
            case UserValidator::$NAME_CHARACTERS_ERROR:
                $updateModel->provideMessage("Incorrect second name", ERROR_TAG);
                return;
        }

        switch ($updateModel->validLastName()) {
            case UserValidator::$NAME_LENGTH_ERROR:
                $updateModel->provideMessage("Last name must be between 3 and 256 characters long", ERROR_TAG);
                return;
            case UserValidator::$NAME_CHARACTERS_ERROR:
                $updateModel->provideMessage("Incorrect last name", ERROR_TAG);
                return;
        }

        switch ($updateModel->validPasswords()) {
            case UserValidator::$PASSWORDS_EMPTY_ERROR:
                $updateModel->provideMessage("Password should not be empty", ERROR_TAG);
                return;
            case UserValidator::$PASSWORD_LENGTH_ERROR:
                $updateModel->provideMessage("Password must be at least 3 characters long", ERROR_TAG);
                return;
            case UserValidator::$PASSWORDS_NOT_SAME_ERROR:
                $updateModel->provideMessage("Passwords are different", ERROR_TAG);
                return;
            case UserValidator::$PASSWORDS_NOT_CONFIRM_ERROR:
                $updateModel->provideMessage("Invalid old password", ERROR_TAG);
                return;
        }

        switch ($updateModel->validPhoto()) {
            case UserValidator::$PHOTO_EXT_ERROR:
                $updateModel->provideMessage("Incorrect image extension", ERROR_TAG);
                return;
            case UserValidator::$PHOTO_SIZE_ERROR:
                $updateModel->provideMessage("Image size should be less 5Mb", ERROR_TAG);
                return;
            case UserValidator::$PHOTO_LOAD_ERROR:
                $updateModel->provideMessage("Could not load the image", ERROR_TAG);
                return;
        }

        $updateModel->update("Profile has been updated", "Update has been failed");
    }

    public function actionLogin($location)
    {

        $loginModel = new LoginModel();

        if (!$loginModel->validPOST()) {
            $loginModel->provideMessage("Invalid request", ERROR_TAG);
            return;
        }

        if ($loginModel->validLogin() !== UserValidator::$SUCCESS ||
            $loginModel->validPassword() !== UserValidator::$SUCCESS) {

            $loginModel->provideMessage("Login or password are incorrect", ERROR_TAG);
            return;
        }

        $loginModel->login($location, "Login or password are incorrect");
    }

    public function actionRegister()
    {
        $registerModel = new RegisterModel();

        if (!$registerModel->validPOST()) {
            $registerModel->provideMessage("Invalid request", ERROR_TAG);
            return;
        }

        switch ($registerModel->validLogin()) {
            case UserValidator::$LOGIN_EMPTY_ERROR:
                $registerModel->provideMessage("Login should not be empty", ERROR_TAG);
                return;
            case UserValidator::$LOGIN_LENGTH_ERROR:
                $registerModel->provideMessage("Login must be between 3 and 256 characters long", ERROR_TAG);
                return;
            case UserValidator::$LOGIN_CHARACTERS_ERROR:
                $registerModel->provideMessage("Login cannot contain spaces", ERROR_TAG);
                return;
            case UserValidator::$LOGIN_RESERVED_ERROR:
                $registerModel->provideMessage("Login has been reserved already", ERROR_TAG);
                return;
        }

        switch ($registerModel->validEmail()) {
            case UserValidator::$EMAIL_EMPTY_ERROR:
                $registerModel->provideMessage("Email should not be empty", ERROR_TAG);
                return;
            case UserValidator::$EMAIL_LENGTH_ERROR:
                $registerModel->provideMessage("Login must be between 3 and 512 characters long", ERROR_TAG);
                return;
            case UserValidator::$EMAIL_VALID_ERROR:
                $registerModel->provideMessage("Incorrect email", ERROR_TAG);
                return;
            case UserValidator::$EMAIL_RESERVED_ERROR:
                $registerModel->provideMessage("Email has been reserved already", ERROR_TAG);
                return;
        }

        switch ($registerModel->validFirstName()) {
            case UserValidator::$NAME_EMPTY_ERROR:
                $registerModel->provideMessage("First name should not be empty", ERROR_TAG);
                return;
            case UserValidator::$NAME_LENGTH_ERROR:
                $registerModel->provideMessage("First name must be between 3 and 256 characters long", ERROR_TAG);
                return;
            case UserValidator::$NAME_CHARACTERS_ERROR:
                $registerModel->provideMessage("Incorrect first name", ERROR_TAG);
                return;
        }

        switch ($registerModel->validSecondName()) {
            case UserValidator::$NAME_EMPTY_ERROR:
                $registerModel->provideMessage("Second name should not be empty", ERROR_TAG);
                return;
            case UserValidator::$NAME_LENGTH_ERROR:
                $registerModel->provideMessage("Second name must be between 3 and 256 characters long", ERROR_TAG);
                return;
            case UserValidator::$NAME_CHARACTERS_ERROR:
                $registerModel->provideMessage("Incorrect second name", ERROR_TAG);
                return;
        }

        switch ($registerModel->validLastName()) {
            case UserValidator::$NAME_LENGTH_ERROR:
                $registerModel->provideMessage("Last name must be between 3 and 256 characters long", ERROR_TAG);
                return;
            case UserValidator::$NAME_CHARACTERS_ERROR:
                $registerModel->provideMessage("Incorrect last name", ERROR_TAG);
                return;
        }

        switch ($registerModel->validPasswords()) {
            case UserValidator::$PASSWORDS_EMPTY_ERROR:
                $registerModel->provideMessage("Password should not be empty", ERROR_TAG);
                return;
            case UserValidator::$PASSWORD_LENGTH_ERROR:
                $registerModel->provideMessage("Password must be at least 3 characters long", ERROR_TAG);
                return;
            case UserValidator::$PASSWORDS_NOT_SAME_ERROR:
                $registerModel->provideMessage("Passwords are different", ERROR_TAG);
                return;
        }

        switch ($registerModel->validPhoto()) {
            case UserValidator::$PHOTO_EXT_ERROR:
                $registerModel->provideMessage("Incorrect image extension", ERROR_TAG);
                return;
            case UserValidator::$PHOTO_SIZE_ERROR:
                $registerModel->provideMessage("Image size should be less 5Mb", ERROR_TAG);
                return;
            case UserValidator::$PHOTO_LOAD_ERROR:
                $registerModel->provideMessage("Could not load the image", ERROR_TAG);
                return;
        }

        $registerModel->register("Register has been completed", "Register has been failed");
    }

    public function actionResetPassword()
    {

        $resetPasswordModel = new ResetPasswordModel();

        if (!$resetPasswordModel->validPOST()) {
            $resetPasswordModel->provideMessage("Invalid request", ERROR_TAG);
        }

        if ($resetPasswordModel->validLogin() !== UserValidator::$SUCCESS) {
            $resetPasswordModel->provideMessage("Login are incorrect", ERROR_TAG);
            return;
        }

        switch ($resetPasswordModel->validPasswords()) {
            case UserValidator::$PASSWORDS_EMPTY_ERROR:
                $resetPasswordModel->provideMessage("Password should not be empty", ERROR_TAG);
                return;
            case UserValidator::$PASSWORD_LENGTH_ERROR:
                $resetPasswordModel->provideMessage("Password must be at least 3 characters long", ERROR_TAG);
                return;
            case UserValidator::$PASSWORDS_NOT_SAME_ERROR:
                $resetPasswordModel->provideMessage("Passwords are different", ERROR_TAG);
                return;
        }

        $resetPasswordModel->reset('Passwords changed', 'Password changing failed');
    }

    public function actionSendEmail()
    {
        $resetPasswordModel = new ResetPasswordModel();

        if (!$resetPasswordModel->validPOST()) {
            $resetPasswordModel->provideMessage("Invalid request", ERROR_TAG);
            return;
        }

        if ($resetPasswordModel->validLogin() !== UserValidator::$SUCCESS) {
            $resetPasswordModel->provideMessage("Login are incorrect", ERROR_TAG);
            return;
        }

        $resetPasswordModel->send("Message has been sent");
    }

    public function actionLogout()
    {
        $logoutModel = new LogoutModel();
        $logoutModel->logout();
    }

}
