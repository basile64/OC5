<?php

namespace application\src\controllers;

use application\src\utils as Util;

class Router {
    private $url;
    private $routes = [];
    private $urlParser;
    private $className;
    private $controller;

        public function __construct($url){
            $this->urlParser = new Util\UrlParser();
            $explodedUrl = $this->urlParser->getExplodedUrl();

            $controllerFileName = (!empty($explodedUrl)) ? ucfirst(strtolower($explodedUrl[0])) . "Controller.php" : "HomepageController.php";
            //On rajoute le chemin depuis index.php
            $controllerFilePath = (!empty($explodedUrl)) ? "../src/controllers/" . ucfirst(strtolower($explodedUrl[0])) . "Controller.php" : "HomepageController.php";
            //On enlève l'extension du fichier et on rajoute le chemin de l'espace de nom
            $controllerClassName =  "application\src\controllers\\".str_replace(".php", "", $controllerFileName);

            if (file_exists($controllerFilePath)) {
                $this->controller = new $controllerClassName($explodedUrl);
            } else {
                $this->controller = new HomepageController;
                //Si la page n'existe pas, on redirige vers erreur 404
                //A faire
            }
        }

}