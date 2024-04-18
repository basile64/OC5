<?php

namespace application\src\models\comment;

class ResponseComment extends Comment
{
    private const RESPONSE_COMMENT_ID_COLUMN = 'id';
    private const MAIN_COMMENT_ID_COLUMN = 'mainCommentId';

    private $responseCommentId;
    private $mainCommentId;

    public function __construct($responseComment) {
        parent::__construct($responseComment);

        $this->setResponseCommentId($responseComment[self::RESPONSE_COMMENT_ID_COLUMN] ?? null);
        $this->setMainCommentId($responseComment[self::MAIN_COMMENT_ID_COLUMN] ?? null);
    }
    
    public function getResponseCommentId() {
        return $this->responseCommentId;
    }

    public function getMainCommentId() {
        return $this->mainCommentId;
    }

    private function setResponseCommentId($responseCommentId) {
        $this->responseCommentId = $responseCommentId;
    }

    private function setMainCommentId($mainCommentId) {
        $this->mainCommentId = $mainCommentId;
    }
    
}
