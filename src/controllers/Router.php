<?php

namespace application\src\controllers;

use application\src\utils\UrlParser;

class Router
{
    
    private $url;
    private $routes = [];
    private $urlParser;
    private $className;
    private $controller;

        public function __construct($url)
        {
            $this->urlParser = new UrlParser();
            $explodedUrl = $this->urlParser->getExplodedUrl();
            if (!empty($explodedUrl)){
                $controllerToLoad = $explodedUrl[0];
                $controllerToLoad = ($controllerToLoad == "mainComment" || $controllerToLoad == "responseComment") ? "comment" : $controllerToLoad;
                // On rajoute le chemin depuis index.php et on enlève l'extension du fichier
                $controllerFileName = ucfirst(strtolower($controllerToLoad)) . "Controller.php";
                $controllerFilePath = "../src/controllers/" . $controllerFileName;
                // On rajoute le chemin de l'espace de nom
                $controllerClassName = "application\src\controllers\\" . str_replace(".php", "", $controllerFileName);
    
                if (file_exists($controllerFilePath)) {
                    $this->controller = new $controllerClassName($explodedUrl);
                } else {
                    $this->controller = new HomepageController;
                }
            } else {
                // Si l'URL est vide, chargez le contrôleur de la page d'accueil
                $this->controller = new HomepageController;
            }
        }

}