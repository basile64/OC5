<?php

namespace application\src\models\comment;

use application\src\models\database\DbConnect;
use application\src\utils\SessionManager;

/**
 * Provides methods to manage responseComment entity.
 */
class ResponseCommentManager 
{

    /**
     * The session manager instance for handling session-related operations.
     *
     * @var SessionManager
     */
    public $sessionManager;

    /**
     * Constructor method for ResponseCommentManager class.
     *
     * Initializes a new instance of ResponseCommentManager class and creates a SessionManager instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }

    /**
     * Retrieves all response comments.
     *
     * @return array An array of ResponseComment objects representing all response comments.
     */
    public static function getAll()
    {
        $query = "
            SELECT
                responseComment.id,
                responseComment.mainCommentId,
                comment.id,
                comment.text,
                comment.status,
                user.firstName as author,
                comment.date as date
            FROM 
                responseComment
            JOIN 
                mainComment ON mainComment.id = responseComment.mainCommentId
            JOIN 
                comment ON comment.id = responseComment.commentId
            JOIN 
                user ON user.id = comment.userId
            ORDER BY 
                date DESC;
        ";

        $result = DbConnect::executeQuery($query);

        $responseComments = [];

        foreach ($result as $responseComment) {
            $responseComments[] = new ResponseComment($responseComment);
        }
        return $responseComments;
    }

    /**
     * Retrieves all response comments by main comment ID.
     *
     * @param int $id The ID of the main comment.
     * @return array An array of ResponseComment objects representing response comments associated with the main comment ID.
     */
    public static function getAllByMainCommentId($id)
    {
        $query = "
            SELECT
                responseComment.id,
                responseComment.mainCommentId,
                comment.id,
                comment.text,
                comment.status,
                user.firstName as author,
                user.id,
                comment.date as date
            FROM 
                responseComment
            JOIN 
                mainComment ON mainComment.id = responseComment.mainCommentId
            JOIN 
                comment ON comment.id = responseComment.commentId
            JOIN 
                user ON user.id = comment.userId
            WHERE
                mainComment.id = :id
            ORDER BY 
                date DESC;
        ";

        $params = [":id" => $id];

        $result = DbConnect::executeQuery($query, $params);

        $responseComments = [];

        foreach ($result as $responseComment) {
            $responseComments[] = new ResponseComment($responseComment);
        }
        return $responseComments;
    }

    /**
     * Retrieves all approved response comments by main comment ID.
     *
     * @param int $id The ID of the main comment.
     * @return array An array of ResponseComment objects representing approved response comments associated with the main comment ID.
     */
    public static function getAllApprovedByMainCommentId($id)
    {
        $query = "
            SELECT
                responseComment.id,
                responseComment.mainCommentId,
                comment.id,
                comment.text,
                comment.status,
                user.firstName as author,
                user.id as userId,
                comment.date
            FROM 
                responseComment
            JOIN 
                mainComment ON mainComment.id = responseComment.mainCommentId
            JOIN 
                comment ON comment.id = responseComment.commentId
            JOIN 
                user ON user.id = comment.userId
            WHERE
                mainComment.id = :id AND comment.status = 'approved'
            ORDER BY 
                date ASC;
        ";

        $params = [":id" => $id];

        $result = DbConnect::executeQuery($query, $params);

        $responseComments = [];

        foreach ($result as $responseComment) {
            $responseComments[] = new ResponseComment($responseComment);
        }
        return $responseComments;
    }

    /**
     * Creates a new response comment.
     *
     * @param int $commentId The ID of the parent comment.
     * @return void
     */
    public function create($commentId)
    {
        $postId = filter_input(INPUT_POST, "postId", FILTER_VALIDATE_INT);
        $mainCommentId = filter_input(INPUT_POST, "mainCommentId", FILTER_VALIDATE_INT);
        
        if ($postId === null || $mainCommentId === null) {
            $this->sessionManager->setSessionVariable("error_message", "Error submitting comment.");
            header("Location: ".BASE_URL."$postId");
            return;
        }
    
        $query="
            INSERT 
            INTO
                responseComment (commentId, mainCommentId)
            VALUES
                (:commentId, :mainCommentId)
        ";
    
        $params = [
            ":commentId" => $commentId,
            ":mainCommentId" => $mainCommentId,
        ];
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result !== false) {
            $this->sessionManager->setSessionVariable("success_message", "Comment submitted.");
            header("Location: ".BASE_URL."post/$postId");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error submitting comment.");
            header("Location: ".BASE_URL."$postId");
            return;
        }
    }
}
