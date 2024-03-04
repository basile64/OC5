<?php

namespace application\src\controllers;

use application\src\models as Model;
use application\src\utils as Util;

class PostController extends Controller{
    private $postManager;
    private $mainCommentManager;
    private $responseCommentManager;
    private $categoryManager;
    private $view;
    private $parsedUrl;

    public function __construct($explodedUrl){
        array_shift($explodedUrl);
        if (is_numeric($explodedUrl[0])){
            $idPost=$explodedUrl[0];
            $this->showSinglePost($idPost);
        }
        // var_dump(parse_url(($explodedUrl[0])));
        // $this->parsedUrl = parse_url($explodedUrl[0]);
        // $parsedUrl = $this->parsedUrl;
        // if (isset($parsedUrl["query"])){
        //     if (preg_match("#^id=\d+$#", $parsedUrl["query"], $matches)){
        //         $idPost=$matches[1];
        //         $this->showSinglePost($idPost);
        //     }
        // }
    }

    public function showPosts(){
        $this->postManager = new Model\post\PostManager();
        $posts = $this->postManager->getPosts();
        $this->view = "post/postsView";
        $this->render($this->view, ["posts"=> $posts]);
    }

    public function showSinglePost($idPost){
        $this->postManager = new Model\post\PostManager();
        $post = $this->postManager->getPost($idPost);

        $this->mainCommentManager = new Model\comment\MainCommentManager();
        $mainComments = $this->mainCommentManager->getMainComments($idPost);

        $this->responseCommentManager = new Model\comment\ResponseCommentManager();
        foreach ($mainComments as $mainComment) {
            $responseComments = $this->responseCommentManager->getResponseComments($mainComment->getId());
            $mainComment->setResponseComments($responseComments);
        }

        $this->view = "post/singlePostView";
        $this->render($this->view, ["post"=> $post, "mainComments" => $mainComments]);
    }


}
