<?php

namespace application\src\controllers;

use application\src\models\post\PostManager;
use application\src\models\comment\CommentManager;
use application\src\models\user\UserManager;
use application\src\models\category\CategoryManager;

use application\src\utils as Util;

class AdminController extends Controller
{
    
    private $class;
    private $action;
    private const ACTION_EDIT = "edit";
    private const ACTION_UPDATE = "update";
    private const ACTION_DELETE = "delete";
    private const ACTION_NEW = "new";
    private const ACTION_CREATE = "create";
    private $manager;
    private $dataKey;
    private $categoryManager;
    private $userManager;

    public function __construct($explodedUrl)
    {
        parent::__construct(); 
        array_shift($explodedUrl);
        $this->class = str_replace("sManagement", "", $explodedUrl[0]);
        if (count($explodedUrl) == 1 && $this->sessionManager->getSessionVariable("userRole") === "admin"){
            $this->loadClassManagement($this->class);
            return; 
        }
        if (count($explodedUrl) > 1 && $this->sessionManager->getSessionVariable("userRole") === "admin") {
            $this->action = $explodedUrl[1];
            $this->runAction($explodedUrl);
            return; 
        }
        header("Location: ".BASE_URL);
        return;
    }

    private function loadClassManagement(){
        switch ($this->class) {
            case "post":
                $this->manager = new PostManager;
                $this->view = "post/postsManagementView";
                $this->dataKey = "posts";
                break;
            case "comment":
                $this->manager = new CommentManager;
                $this->view = "comment/commentsManagementView";
                $this->dataKey = "comments";
                break;
            case "user":
                $this->manager = new UserManager;
                $this->view = "user/usersManagementView";
                $this->dataKey = "users";
                break;
            default:
                break;
        }
        $this->loadManagement();
    }
    
    private function loadManagement()
    {
        if ($this->class !== "comment") {
            $data = [$this->dataKey => $this->manager->getAll()];
        } else {
            $data = [$this->dataKey => $this->manager->getAllPending()];
        }
        $this->render($data);
    }
    
    private function runAction($explodedUrl)
    {
        $id = ($explodedUrl[2] ?? null);

        $managerClassName = "application\src\models\\".$this->class."\\".ucfirst($this->class)."Manager";

        $actionName = $this->action;

        $this->manager = new $managerClassName();
        if ($id !== null) {
            $result = $this->manager->{$actionName}($id);
        } else {
            $result = $this->manager->{$actionName}();
        }

        // Nous avons besoin d'une vue s'il faut éditer ou ajouter un nouveau post/utilisateur
        if ($this->action == self::ACTION_EDIT || $this->action == self::ACTION_NEW){
            $this->view = $this->class . "/" . $this->action . ucfirst($this->class) . "View";
            $this->manager = new PostManager();
            $this->categoryManager = new CategoryManager;
            $categories = $this->categoryManager->getAll();
            $this->userManager = new UserManager;
            $authors = $this->userManager->getAllAdmin();
            $this->render([$this->class => $result, "categories" => $categories, "authors" => $authors]);
        }
    }

}
