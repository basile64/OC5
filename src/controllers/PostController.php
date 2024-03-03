<?php

namespace application\src\controllers;

use application\src\controllers as Controller;
use application\src\models as Model;

class PostController {
    private $postManager;
    private $commentManager;
    private $categoryManager;
    private $view;

    public function showPosts(){
        $this->postManager = new Model\post\PostManager();
        $posts = $this->postManager->getPosts();
        $this->view = "post/postsView.php";
        $this->render($view, ["posts"=> $posts]);
    }
}
