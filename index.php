<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

const ROOT = __DIR__;
require_once ROOT.'/components/Router.php';

$route = new Router();
$route->run();