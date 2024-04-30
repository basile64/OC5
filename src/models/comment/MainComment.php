<?php

namespace application\src\models\comment;

use application\src\models\comment\ResponseCommentManager;

/**
 * Represents a mainComment entity.
 */
class MainComment extends Comment
{

    /**
     * The name of the column storing the main comment ID.
     */
    private const MAIN_COMMENT_ID_COLUMN = 'id';

    /**
     * The ID of the main comment.
     *
     * @var mixed
     */
    private $mainCommentId;

    /**
     * Constructor method for MainComment class.
     *
     * Initializes a new instance of MainComment class with the provided data.
     *
     * @param array $mainComment The data representing the main comment.
     * @return void
     */
    public function __construct($mainComment)
    {
        // Call the parent constructor to initialize inherited properties
        parent::__construct($mainComment);  
        
        // Set the main comment ID
        $this->setMainCommentId($mainComment[self::MAIN_COMMENT_ID_COLUMN] ?? null);
    }
    
    /**
     * Get the ID of the main comment.
     *
     * @return mixed The main comment ID.
     */
    public function getMainCommentId()
    {
        return $this->mainCommentId;
    }

    /**
     * Get the response comments associated with the main comment.
     *
     * @return array An array of response comments.
     */
    public function getResponseComments()
    {
        // Create an instance of ResponseCommentManager to retrieve response comments
        $responseCommentManager = new ResponseCommentManager;
        // Get all approved response comments by main comment ID
        $responseComments = $responseCommentManager->getAllApprovedByMainCommentId($this->mainCommentId);
        return $responseComments;
    }

    /**
     * Set the main comment ID.
     *
     * @param mixed $mainCommentId The main comment ID.
     * @return void
     */
    private function setMainCommentId($mainCommentId)
    {
        $this->mainCommentId = $mainCommentId;
    }

}
