<?php

spl_autoload_register(function($className){
    $className = str_replace("\\", "/", $className);
    $className = str_replace("application/", "", $className);

    require_once("../$className.php");
});