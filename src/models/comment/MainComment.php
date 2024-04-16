<?php

namespace application\src\models\comment;

use application\src\models\comment\ResponseCommentManager;

class MainComment extends Comment {
    private const MAIN_COMMENT_ID_COLUMN = 'id';

    private $mainCommentId;

    public function __construct($mainComment){
        parent::__construct($mainComment);  
        
        $this->setMainCommentId($mainComment[self::MAIN_COMMENT_ID_COLUMN] ?? null);
    }
    
    public function getMainCommentId() {
        return $this->mainCommentId;
    }

    public function getResponseComments(){
        $responseCommentManager = new ResponseCommentManager;
        $responseComments = $responseCommentManager->getAllApprovedByMainCommentId($this->mainCommentId);
        return $responseComments;
    }

    private function setMainCommentId($mainCommentId) {
        $this->mainCommentId = $mainCommentId;
    }

}
