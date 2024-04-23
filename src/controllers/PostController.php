<?php

namespace application\src\controllers;

use application\src\models\post\PostManager;
use application\src\models\comment\MainCommentManager;
use application\src\models\comment\ResponseCommentManager;
use application\src\models\comment\MainComment;

class PostController extends Controller
{

    private $postManager;
    private $mainCommentManager;
    private $responseCommentManager;

    public function __construct($explodedUrl)
    {
        parent::__construct(); 
        if (is_numeric($explodedUrl[1]) == true && isset($explodedUrl[2]) == false){
            $idPost = $explodedUrl[1];
            $this->showSingle($idPost);
        //Pour les getNextPost et getPreviousPost
        } else if (isset($explodedUrl[2])) {
            $idPost = $explodedUrl[1];
            $action = $explodedUrl[2];
            if (method_exists($this, $action) == true) {
                $this->$action($idPost);
            } else {
                header("Location: ".BASE_URL);
            }
        } else {
            header("Location: ".BASE_URL);
        }
    }

    public function showPosts()
    {
        $this->postManager = new PostManager();
        $posts = $this->postManager->getAll();
        $this->view = "post/postsView";
        $this->render(["posts" => $posts]);
    }

    public function showSingle($postId)
    {
        $this->postManager = new PostManager();
        $post = $this->postManager->get($postId);

        $this->mainCommentManager = new MainCommentManager();
        $mainComments = $this->mainCommentManager->getAllApprovedByPostId($postId);

        $this->responseCommentManager = new ResponseCommentManager();

        $this->view = "post/singlePostView";
        $this->render(["post"=> $post]);
    }

    private function getNext($postId)
    {
        $this->postManager = new PostManager();
        $nextPost = $this->postManager->getNext($postId);
        $nextPostId = $nextPost->getId();
        if ($nextPostId !== null) {
            header("Location: ".BASE_URL."post/".$nextPostId);
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "This is the last post.");
            header("Location: ".BASE_URL."post/".$postId);
            return;
        }
    }

    private function getPrevious($postId)
    {
        $this->postManager = new PostManager();
        $previousPost = $this->postManager->getPrevious($postId);
        $previousPostId = $previousPost->getId();
        if ($previousPostId !== null) {
            header("Location: ".BASE_URL."post/".$previousPostId);
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "This is the first post.");
            header("Location: ".BASE_URL."post/".$postId);
            return;
        }
    }

}
