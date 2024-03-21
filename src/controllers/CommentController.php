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
    private $class;
    private $action;

    public function __construct($explodedUrl){
        if (isset($_SESSION["logged"])){
            $this->class = $explodedUrl[0];
            $this->action = $explodedUrl[1];
            //call_user_func([$Instance dans laquelle nous voulons exécuter la méthode, $méthode à exécuter], $arguments)
            $this->runAction($explodedUrl);
        } else {
            header("Location: http://localhost/OC5/");
        }
    }

    private function runAction($explodedUrl){
        call_user_func([$this, $this->action . "Comment"]);
    }

    private function createComment(){
        $this->commentManager = new CommentManager();
        if (call_user_func([$this->commentManager, $this->action . "Comment"])){
            $idComment = DbConnect::$connection->lastInsertId();
            //Si pas de idMainComment dans $_POST, alors il ne s'agit pas d'une réponse à un autre commentaire
            if (!isset($_POST["idMainComment"])){
                $this->mainCommentManager = new MainCommentManager();
                call_user_func([$this->mainCommentManager, "createMainComment"], $idComment);
            } else {
                $this->responseCommentManager = new ResponseCommentManager();
                call_user_func([$this->responseCommentManager, "createResponseComment"], $idComment);
            }
        }
    }
}
