<?php

namespace application\src\models\comment;

/**
 * Represents a responseComment entity.
 */
class ResponseComment extends Comment
{
    
    /**
     * The column name for the response comment ID.
     */
    private const RESPONSE_COMMENT_ID_COLUMN = 'id';
    
    /**
     * The column name for the main comment ID associated with the response comment.
     */
    private const MAIN_COMMENT_ID_COLUMN = 'mainCommentId';

    /**
     * The ID of the response comment.
     *
     * @var int
     */
    private $responseCommentId;

    /**
     * The ID of the main comment associated with the response comment.
     *
     * @var int
     */
    private $mainCommentId;

    /**
     * Constructor method for ResponseComment class.
     *
     * Initializes a new instance of ResponseComment class by calling the parent constructor and setting additional properties.
     *
     * @param array $responseComment An array containing response comment data.
     * @return void
     */
    public function __construct($responseComment)
    {
        parent::__construct($responseComment);

        $this->setResponseCommentId($responseComment[self::RESPONSE_COMMENT_ID_COLUMN] ?? null);
        $this->setMainCommentId($responseComment[self::MAIN_COMMENT_ID_COLUMN] ?? null);
    }
    
    /**
     * Getter method for retrieving the response comment ID.
     *
     * @return int The response comment ID.
     */
    public function getResponseCommentId()
    {
        return $this->responseCommentId;
    }

    /**
     * Getter method for retrieving the main comment ID associated with the response comment.
     *
     * @return int The main comment ID.
     */
    public function getMainCommentId()
    {
        return $this->mainCommentId;
    }

    /**
     * Setter method for setting the response comment ID.
     *
     * @param int $responseCommentId The ID of the response comment.
     * @return void
     */
    private function setResponseCommentId($responseCommentId)
    {
        $this->responseCommentId = $responseCommentId;
    }

    /**
     * Setter method for setting the main comment ID associated with the response comment.
     *
     * @param int $mainCommentId The ID of the main comment.
     * @return void
     */
    private function setMainCommentId($mainCommentId)
    {
        $this->mainCommentId = $mainCommentId;
    }
}
