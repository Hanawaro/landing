<?php

require_once ROOT . '/controllers/interfaces/UserControllerInterface.php';
require_once ROOT . '/repository/ProfileRepository.php';

class ProfileController extends UserControllerInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->require();
    }

    public function actionInit()
    {
        require_once(ROOT . '/views/profile/profile.php');
    }

    public function actionUpdate()
    {

        require_once(ROOT . '/views/profile/update.php');
    }

    public function get($key)
    {

        $result = $this->getUpdate($key);

        if ($key === OLD_PASSWORD_TAG || $key === PASSWORD_TAG || $key === RE_PASSWORD_TAG)
            return '';
        if ($key === ERROR_TAG || $key === SUCCESS_TAG) {
            return $result;
        }

        if (empty($result))
            return ProfileRepository::get($key);
        return $result;
    }
}