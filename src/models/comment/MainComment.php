<?php

namespace application\src\models\comment;

use application\src\models\comment\ResponseCommentManager;

class MainComment extends Comment {
    private $idMainComment;

    public function __construct($mainComment){
        parent::__construct($mainComment);  
        
        $this->setIdMainComment($mainComment['idMainComment'] ?? null);
    }
    
    public function getIdMainComment() {
        return $this->idMainComment;
    }

    public function getResponseComments(){
        $responseCommentManager = new ResponseCommentManager;
        $responseComments = $responseCommentManager->getAllApprovedByIdMainComment($this->idMainComment);
        return $responseComments;
    }

    public function setIdMainComment($idMainComment) {
        $this->idMainComment = $idMainComment;
    }

}