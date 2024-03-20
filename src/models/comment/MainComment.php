<?php

namespace application\src\models\comment;

class MainComment extends Comment {
    private $idMainComment;
    private $responseComments;

    public function __construct($mainComment){
        parent::__construct($mainComment);  
        
        $this->setIdMainComment($mainComment['idMainComment'] ?? null);
        $this->setResponseComments($mainComment['responseComments'] ?? null);
    }
    
    public function getIdMainComment() {
        return $this->idMainComment;
    }

    public function getResponseComments(){
        return $this->responseComments;
    }

    public function setIdMainComment($idMainComment) {
        $this->idMainComment = $idMainComment;
    }

    public function setResponseComments($responseComments){
        $this->responseComments = $responseComments;
    }

}