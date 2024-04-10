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
    private $action;

    public function __construct($explodedUrl){
        if (is_numeric($explodedUrl[1]) && !isset($explodedUrl[2])){
            $idPost=$explodedUrl[1];
            $this->showSinglePost($idPost);
        //Pour les getNextPost et getPreviousPost
        } elseif (isset($explodedUrl[2])){
            $idPost = $explodedUrl[1];
            $action = $explodedUrl[2];
            if (method_exists($this, $action)) {
                $this->$action($idPost);
            } else {
                header("Location: http://localhost/OC5/");
            }
        } else {
            header("Location: http://localhost/OC5/");
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

    private function getNextPost($idPost){
        $this->postManager = new PostManager();
        $nextPost = $this->postManager->getNextPost($idPost);
        $idNextPost = $nextPost->getId();
        if ($idNextPost != null){
            header("Location: http://localhost/OC5/post/".$idNextPost);
        } else {
            $_SESSION["error_message"] = "This is the last post.";
            header("Location: http://localhost/OC5/post/".$idPost);
        }
    }

    private function getPreviousPost($idPost){
        $this->postManager = new PostManager();
        $previousPost = $this->postManager->getPreviousPost($idPost);
        $idPreviousPost = $previousPost->getId();
        if ($idPreviousPost != null){
            header("Location: http://localhost/OC5/post/".$idPreviousPost);
        } else {
            $_SESSION["error_message"] = "This is the first post.";
            header("Location: http://localhost/OC5/post/".$idPost);
        }
    }

}
