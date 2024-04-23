<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

use application\src\utils\SessionManager;
use application\src\controllers\Router;

require_once "../config/autoload.php";
require_once "../config/config.php";

$sessionManager = new SessionManager;

if ($sessionManager->getSessionVariable("success_message") !== null) {
    echo '<div class="success-message">'.$sessionManager->getSessionVariable("success_message").'</div>';
    $sessionManager->unsetSessionVariable("success_message");
} else if ($sessionManager->getSessionVariable("error_message") !== null) {
    echo '<div class="error-message">'.$sessionManager->getSessionVariable("error_message").'</div>';
    $sessionManager->unsetSessionVariable("error_message");
}

$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
$router = new Router($url);