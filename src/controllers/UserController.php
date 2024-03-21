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
    private $class;
    private $action;

    public function __construct($explodedUrl){
        $this->class = $explodedUrl[0];
        $this->action = $explodedUrl[1];
        $this->runAction($explodedUrl);
    }

    private function runAction($explodedUrl){
        $this->userManager = new UserManager;
        $result = call_user_func([$this->userManager, $this->action . ucfirst($this->class)]);
        $this->view = $this->class . "/" . $this->action . ucfirst($this->class) . "View";
        $this->render([$this->class => $result]);
    }

}
