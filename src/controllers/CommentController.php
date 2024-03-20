<?php

namespace application\src\controllers;

use application\src\models\database\DbConnect;
use application\src\models\comment\Comment;
use application\src\models\comment\CommentManager;
use application\src\models\comment\MainCommentManager;
use application\src\models\comment\ResponseCommentManager;

class CommentController extends Controller{
    private $commentManager;
    private $mainCommentManager;
    private $responseCommentManager;
    private $parsedUrl;
    private $action;

    public function __construct($explodedUrl){
        $classToLoad = $explodedUrl[0];
        $this->action = $explodedUrl[1];
        //call_user_func([$Instance dans laquelle nous voulons exécuter la méthode, $méthode à exécuter], $arguments)
        $this->runAction($classToLoad, $explodedUrl);
    }

    private function runAction($classToLoad, $explodedUrl){
        call_user_func([$this, $this->action . "Comment"]);
    }

    private function addComment(){
        $this->commentManager = new CommentManager();
        if (call_user_func([$this->commentManager, $this->action . "Comment"])){
            $idComment = DbConnect::$connection->lastInsertId();
            //Si pas de idMainComment dans $_POST, alors il ne s'agit pas d'une réponse à un autre commentaire
            if (!isset($_POST["idMainComment"])){
                $this->mainCommentManager = new MainCommentManager();
                call_user_func([$this->mainCommentManager, "addMainComment"], $idComment);
            } else {
                $this->responseCommentManager = new ResponseCommentManager();
                call_user_func([$this->responseCommentManager, "addResponseComment"], $idComment);
            }
        }
    }
}
