<?php

namespace application\src\controllers;

use application\src\models\database\DbConnect;
use application\src\models\user\User;
use application\src\models\user\UserManager;
use application\src\models\comment\CommentManager;
use application\src\models\user\BasicUserManager;
use application\src\models\user\AdminUserManager;

class UserController extends Controller{
    private $userManager;
    private $commentManager;
    private $parsedUrl;
    private $class;
    private $action;

    public function __construct($explodedUrl){
        $this->class = $explodedUrl[0];
        if (isset($explodedUrl[2]) && $explodedUrl[2]=="delete" && isset($explodedUrl[3]) && is_numeric($explodedUrl[3])){
            $this->commentManager = new CommentManager();
            $this->commentManager->deleteComment($explodedUrl[3]);
        } else {
            $this->action = $explodedUrl[1];
            $this->runAction($explodedUrl);
        }
    }

    private function runAction($explodedUrl){
        if ($this->action != "comments"){
            $this->userManager = new UserManager();
            $result = call_user_func([$this->userManager, $this->action . ucfirst($this->class)]);
            $this->view = $this->class . "/" . $this->action . ucfirst($this->class) . "View";
            $this->render([$this->class => $result]);
        } else {
            $this->commentManager = new CommentManager();
            $result = $this->commentManager->getAllApprovedByUser(); 
            $this->view = $this->class . "/" . $this->action . ucfirst($this->class) . "View";
            $this->render(["comments" => $result]);
        }
    }

}