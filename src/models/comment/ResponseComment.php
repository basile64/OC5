<?php

namespace application\src\models\comment;

class ResponseComment extends Comment {
    private $idResponseComment;
    
    public function getId() {
        return $this->idResponseComment;
    }

    public function setId($idResponseComment) {
        $this->idResponseComment = $idResponseComment;
    }
}