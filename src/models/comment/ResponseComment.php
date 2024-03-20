<?php

namespace application\src\models\comment;

class ResponseComment extends Comment {
    private $idResponseComment;
    private $idMainComment;

    public function __construct($responseComment) {
        parent::__construct($responseComment);

        $this->setIdResponseComent($responseComment['idResponseComment'] ?? null);
        $this->setIdMainComment($responseComment['idMainComment'] ?? null);
    }
    
    public function getIdResponseComent() {
        return $this->idResponseComment;
    }

    public function getIdMainComment() {
        return $this->idMainComment;
    }

    public function setIdResponseComent($idResponseComment) {
        $this->idResponseComment = $idResponseComment;
    }

    public function setIdMainComment($idMainComment) {
        $this->idMainComment = $idMainComment;
    }
    
}