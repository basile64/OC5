<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION["success_message"])){
    echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

require_once("../config/autoload.php");
use application\src\controllers as Controller;

$router = new Controller\Router($_GET["url"]);

