<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../config/autoload.php");
use application\src\controllers as Controller;
use application\src\models as Model;


$router = new Model\router\Router($_GET["url"]);

$router->addRouteGet("/", [new Controller\HomepageController(), "showHomePage"]);
// $router->addRouteGet("/posts", require_once("../src/controllers/homepageController.php"));
// $router->addRouteGet("/post/:id", require_once("../src/controllers/postController.php"));

$router->run();