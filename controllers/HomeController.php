<?php

require_once 'interfaces/UserControllerInterface.php';

class HomeController extends UserControllerInterface
{

    public function actionInit()
    {
        require_once(ROOT . '/views/home/home.php');
    }

}