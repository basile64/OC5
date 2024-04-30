<?php

namespace application\src\controllers;

use application\src\utils\UrlParser;

class Router
{
    
    /**
     * The URL parser instance.
     *
     * @var UrlParser
     */
    private $urlParser;

    /**
     * The controller instance to be loaded based on the URL.
     *
     * @var mixed
     */
    private $controller;

    /**
     * Constructor method.
     * 
     * Initializes a new instance of the Router class.
     * Determines the controller to load based on the provided URL.
     * 
     * @param string $url The URL to parse.
     */
    public function __construct($url)
    {
        $this->urlParser = new UrlParser();
        $explodedUrl = $this->urlParser->getExplodedUrl();

        // Check if URL is not empty
        if (!empty($explodedUrl)){
            // Determine controller to load
            $controllerToLoad = $explodedUrl[0];
            // Map "mainComment" and "responseComment" controllers to "comment" controller
            $controllerToLoad = ($controllerToLoad === "mainComment" || $controllerToLoad === "responseComment") ? "comment" : $controllerToLoad;

            // Construct file path and class name for the controller
            $controllerFileName = ucfirst(strtolower($controllerToLoad)) . "Controller.php";
            $controllerFilePath = "../src/controllers/" . $controllerFileName;
            $controllerClassName = "application\src\controllers\\" . str_replace(".php", "", $controllerFileName);

            // Load the controller if file exists; otherwise, load the HomepageController
            if (file_exists($controllerFilePath)) {
                $this->controller = new $controllerClassName($explodedUrl);
            } else {
                $this->controller = new HomepageController;
            }
        } else {
            // If URL is empty, load the HomepageController
            $this->controller = new HomepageController;
        }
    }
}
