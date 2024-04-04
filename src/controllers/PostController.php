<?php

namespace application\src\controllers;

use application\src\models\post\PostManager;
use application\src\models\comment\MainCommentManager;
use application\src\models\comment\ResponseCommentManager;
use application\src\models\comment\MainComment;
use application\src\utils as Util;

class PostController extends Controller{
    private $postManager;
    private $mainCommentManager;
    private $responseCommentManager;
    private $categoryManager;
    private $parsedUrl;

    public function __construct($explodedUrl){
        array_shift($explodedUrl);
        if (is_numeric($explodedUrl[0])){
            $idPost=$explodedUrl[0];
            $this->showSinglePost($idPost);
        }
    }

    public function showPosts(){
        $this->postManager = new PostManager();
        $posts = $this->postManager->getAll();
        $this->view = "post/postsView";
        $this->render(["posts"=> $posts]);
    }

    public function showSinglePost($idPost){
        $this->postManager = new PostManager();
        $post = $this->postManager->getPost($idPost);

        $this->mainCommentManager = new MainCommentManager();
        $mainComments = $this->mainCommentManager->getAllApprovedByIdPost($idPost);

        $this->responseCommentManager = new ResponseCommentManager();

        $this->view = "post/singlePostView";
        $this->render(["post"=> $post]);
    }

}
