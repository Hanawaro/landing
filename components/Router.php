<?php

class Router {

    private $routes;

    public function __construct() {
        $path = ROOT.'/config/routes.php';
        $this->routes = include($path);
    }

    public function run() {
        $uri = $this->getUri();
        foreach ($this->routes as $route => $path) {

            if (preg_match("~^$route$~", $uri)) {

                $innerRoute = preg_replace("~$route~", $path, $uri);

                $segments = explode('/', $innerRoute);

                $controllerName = ucfirst(array_shift($segments).'Controller');
                $actionName = 'action'.ucfirst(array_shift($segments));

                $controllerPath = ROOT.'/controllers/'.$controllerName.'.php';
                if (file_exists($controllerPath)) {
                    include_once($controllerPath);
                }

                session_start();

                $controller = new $controllerName;
                call_user_func_array(array($controller, $actionName), $segments);
                break;
            }
        }
    }

    private function getUri(): string {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        return '';
    }
}