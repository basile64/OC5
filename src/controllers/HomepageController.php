<?php

namespace application\src\controllers;

use application\src\models as Model;

class HomepageController extends Controller
{

    private $postManager;

    public function __construct()
    {
        parent::__construct(); 
        $this->showHomePage();
    }

    public function showHomePage()
    {
        $this->postManager = new Model\post\PostManager();
        $posts = $this->postManager->getAll();
        $this->view = "homepageView";
        $this->render(["posts" => $posts, "sessionManager" => $this->sessionManager]);
    }

}

