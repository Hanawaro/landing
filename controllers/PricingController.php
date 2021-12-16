<?php

require_once 'interfaces/UserControllerInterface.php';
require_once ROOT . '/models/PricingModel.php';

class PricingController extends UserControllerInterface
{

    private $pricingModel;

    public function __construct()
    {
        parent::__construct();
        $this->pricingModel = new PricingModel();
    }

    public function actionInit()
    {
        $carts = $this->pricingModel->getCarts();
        require_once(ROOT . '/views/pricing/pricing.php');
    }

}