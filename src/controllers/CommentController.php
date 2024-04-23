<?php

namespace application\src\controllers;

use application\src\models\database\DbConnect;
use application\src\models\comment\Comment;
use application\src\models\comment\CommentManager;
use application\src\models\comment\MainCommentManager;
use application\src\models\comment\ResponseCommentManager;

class CommentController extends Controller
{

    private $commentManager;
    private $mainCommentManager;
    private $responseCommentManager;
    private $class;
    private $action;

    public function __construct($explodedUrl)
    {
        parent::__construct(); 
        if ($this->sessionManager->getSessionVariable("logged") === true) {
            $this->class = $explodedUrl[0];
            $this->action = $explodedUrl[1];
            $this->runAction();
            return;
        }
        $this->sessionManager->setSessionVariable("error_message", "You have to be logged.");
        header("Location: ".htmlspecialchars(htmlspecialchars(BASE_URL)));
        return;
    }

    private function runAction()
    {
        $this->{$this->action . "Comment"}();
    }

    private function createComment()
    {
        $this->commentManager = new CommentManager();
        if ($this->commentManager->{$this->action}() === true) {
            $commentId = DbConnect::$connection->lastInsertId();
            // Si pas de idMainComment dans $_POST, alors il ne s'agit pas d'une réponse à un autre commentaire
            $idMainComment = filter_input(INPUT_POST, 'idMainComment', FILTER_VALIDATE_INT);

            if ($idMainComment === null) {
                $this->mainCommentManager = new MainCommentManager();
                $this->mainCommentManager->create($commentId);
                return;
            }
            
            $this->responseCommentManager = new ResponseCommentManager();
            $this->responseCommentManager->create($commentId);
        }
    }
}
