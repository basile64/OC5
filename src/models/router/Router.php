<?php

namespace application\src\models\router;

class Router {
    private $url;
    private $routes = [];

    public function __construct($url){
        $this->setUrl($url);
    }

    private function setUrl($url){
        $this->url = $url;
    }

    public function addRouteGet($path, $callable){
        $route = new Route($path, $callable);
        $this->routes["GET"][] = $route;
    }

    public function addRoutePost($path, $callable){
        $route = new Route($path, $callable);
        $this->routes["POST"][] = $route;
    }

    public function run(){
        if (!isset($this->routes[$_SERVER["REQUEST_METHOD"]])){
            throw new RouterException("REQUEST_METHOD doesn't exist.");
        }
        foreach($this->routes[$_SERVER["REQUEST_METHOD"]] as $route){
            if ($route->match($this->url)){
                return $route->call();
            }
        }
        throw new RouterException("No matching routes.");
    }
}