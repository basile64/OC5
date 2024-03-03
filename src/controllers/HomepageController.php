<?php

namespace application\src\controllers;

use application\src\controllers as Controller;
use application\src\models as Model;

class HomepageController extends Controller\Controller {
    private $postManager;
    private $view;

    public function showHomePage(){
        $this->postManager = new Model\post\PostManager();
        $posts = $this->postManager->getPosts();
        $this->view = "homepageView";
        $this->render($this->view, ["posts"=> $posts]);
    }
}

