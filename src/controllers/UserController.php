<?php

namespace application\src\controllers;

use application\src\models\database\DbConnect;
use application\src\models\user\User;
use application\src\models\user\UserManager;
use application\src\models\user\BasicUserManager;
use application\src\models\user\AdminUserManager;

class UserController extends Controller{
    private $userManager;
    private $parsedUrl;
    private $action;

    public function __construct($explodedUrl){
        $classToLoad = $explodedUrl[0];
        $this->action = $explodedUrl[1];
        //call_user_func([$Instance dans laquelle nous voulons exécuter la méthode, $méthode à exécuter], $arguments)
        $this->runAction($classToLoad, $explodedUrl);
    }

    private function runAction($classToLoad, $explodedUrl){
        call_user_func([$this, $this->action . "User"]);
    }

}
