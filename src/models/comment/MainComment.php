<?php

namespace application\src\models\comment;

class MainComment extends Comment {
    private $idMainComment;
    private $responseComments;
    
    public function getId() {
        return $this->idMainComment;
    }

    public function getResponseComments() {
        return $this->responseComments;
    }

    public function setId($idMainComment) {
        $this->idMainComment = $idMainComment;
    }

    public function setResponseComments($responseComments) {
        $this->responseComments = $responseComments;
    }

}