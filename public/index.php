<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../config/autoload.php");
use application\src\controllers as Controller;

$router = new Controller\Router($_GET["url"]);

