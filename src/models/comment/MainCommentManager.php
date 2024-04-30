<?php

namespace application\src\models\comment;

use application\src\models\database\DbConnect;
use application\src\models\comment\MainComment;
use application\src\utils\SessionManager;

/**
 * Provides methods to manage mainComment entity.
 */
class MainCommentManager
{

    /**
     * Instance of SessionManager for handling session-related operations.
     *
     * @var SessionManager
     */
    public $sessionManager;

    /**
     * Constructor method for MainCommentManager class.
     *
     * Initializes a new instance of MainCommentManager class and creates an instance of SessionManager.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }

    /**
     * Retrieves all main comments with associated data from the database.
     *
     * @return array An array of MainComment objects.
     */
    public static function getAll()
    {
        $query = "
            SELECT
                comment.id,
                comment.text,
                comment.status,
                user.firstName as author,
                DATE_FORMAT(comment.date, '%d/%m/%Y') AS date,
                post.id as postId
            FROM 
                comment
            JOIN 
                user ON user.id = comment.userId
            JOIN
                mainComment ON mainComment.commentId = comment.id
            JOIN
                post ON post.id = comment.postId
            ORDER BY 
                date DESC
        ";

        $result = DbConnect::executeQuery($query);

        $mainComments = [];

        foreach ($result as $mainComment) {
            $mainComments[] = new MainComment($mainComment);
        }
        return $mainComments;

    }

    /**
     * Retrieves all main comments associated with a specific post ID from the database.
     *
     * @param int $postId The ID of the post.
     * @return array An array of MainComment objects associated with the specified post ID.
     */
    public static function getAllByPostId($postId)
    {
        $query = "
            SELECT
                comment.text,
                comment.status,
                comment.date,
                mainComment.commentId,
                mainComment.id,
                user.firstName as author,
                post.id as postId,
                user.id
            FROM 
                comment
            JOIN 
                user ON user.id = comment.userId
            JOIN
                mainComment ON mainComment.commentId = comment.id
            JOIN
                post ON post.id = comment.postId
            WHERE
                post.id = :postId
            ORDER BY 
                date DESC
        ";


        $params = [":postId" => $postId];

        $result = DbConnect::executeQuery($query, $params);

        $mainComments = [];

        foreach ($result as $mainComment) {
            $mainComments[] = new MainComment($mainComment);
        }
        return $mainComments;

    }

    /**
     * Retrieves all approved main comments associated with a specific post ID from the database.
     *
     * @param int $postId The ID of the post.
     * @return array An array of MainComment objects with approved status associated with the specified post ID.
     */
    public static function getAllApprovedByPostId($postId)
    {
        $query = "
            SELECT
                comment.text,
                comment.status,
                comment.date,
                mainComment.commentId,
                mainComment.id,
                user.firstName as author,
                post.id as postId,
                user.id as userId
            FROM 
                comment
            JOIN 
                user ON user.id = comment.userId
            JOIN
                mainComment ON mainComment.commentId = comment.id
            JOIN
                post ON post.id = comment.postId
            WHERE
                post.id = :postId AND comment.status = 'approved'
            ORDER BY 
                date DESC
        ";


        $params = [":postId" => $postId];

        $result = DbConnect::executeQuery($query, $params);

        $mainComments = [];

        foreach ($result as $mainComment) {
            $mainComments[] = new MainComment($mainComment);
        }
        return $mainComments;

    }
    
    /**
     * Creates a new main comment in the database.
     *
     * @param int $commentId The ID of the associated comment.
     * @return void
     */
    public function create($commentId)
    {
        $postId = filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT);

        if ($postId === null) {
            $this->sessionManager->setSessionVariable("error_message", "Error submitting comment.");
            header("Location: ".BASE_URL);
            return;
        }
    
        $query="
            INSERT 
            INTO
                mainComment (commentId)
            VALUES
                (:commentId)
        ";
    
        $params = [
            ":commentId" => $commentId
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
