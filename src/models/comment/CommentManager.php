<?php

namespace application\src\models\comment;

use application\src\models\comment\Comment;
use application\src\models\database\DbConnect;
use application\src\utils\SessionManager;

/**
 * Provides methods to manage comment entity.
 */
class CommentManager
{
    
    /**
     * Instance of SessionManager for handling session-related operations.
     *
     * @var SessionManager
     */
    private $sessionManager;

    /**
     * Constructor method for CommentManager class.
     *
     * Initializes a new instance of CommentManager class and creates an instance of SessionManager.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }

    /**
     * Retrieves all comments with associated data from the database.
     *
     * @return array An array of Comment objects.
     */
    public function getAll()
    {
        $query = "
            SELECT 
                C.id,
                C.date,
                C.text,
                C.status,
                C.postId,
                C.userId,
                RC.mainCommentId

            FROM 
                comment AS C
            LEFT JOIN 
                mainComment AS MC ON C.id = MC.commentId
            LEFT JOIN 
                responseComment AS RC ON C.id = RC.commentId
        ";

        $result = DbConnect::executeQuery($query);

        $comments = [];
        foreach ($result as $commentData) {
            if (!empty($commentData['postId'])) {
                $comment = new MainComment($commentData);
            } else {
                $comment = new ResponseComment($commentData);
            }
            $comments[] = $comment;
        }

        return $comments;
    }

    /**
     * Retrieves all pending comments with associated data from the database.
     *
     * @return array An array of Comment objects with 'pending' status.
     */
    public function getAllPending()
    {
        $query = "
            SELECT 
                C.id,
                C.date,
                C.text,
                C.status,
                C.postId,
                C.userId,
                RC.mainCommentId

            FROM 
                comment AS C
            LEFT JOIN 
                mainComment AS MC ON C.id = MC.commentId
            LEFT JOIN 
                responseComment AS RC ON C.id = RC.commentId
            WHERE
                C.status = 'pending'
            ORDER BY
                C.date DESC
        ";

        $result = DbConnect::executeQuery($query);

        $comments = [];
        foreach ($result as $commentData) {
            if (!empty($commentData['postId'])) {
                $comment = new MainComment($commentData);
            } else {
                $comment = new ResponseComment($commentData);
            }
            $comments[] = $comment;
        }

        return $comments;
    }
    
    /**
     * Retrieves all approved comments by the current user from the database.
     *
     * @return array An array of Comment objects with 'approved' status associated with the current user.
     */
    public function getAllApprovedByUser()
    {
        $this->sessionManager = new SessionManager;

        $query = "
            SELECT 
                C.id,
                C.date,
                C.text,
                C.status,
                C.postId,
                C.userId,
                RC.mainCommentId

            FROM 
                comment AS C
            LEFT JOIN 
                MainComment AS MC ON C.id = MC.commentId
            LEFT JOIN 
                responseComment AS RC ON C.id = RC.commentId
            WHERE
                C.status = 'approved' AND C.userId = :userId
            ORDER BY
                C.date DESC
        ";

        $params= [
            ":userId" => $this->sessionManager->getSessionVariable("userId")
        ];

        $result = DbConnect::executeQuery($query, $params);

        $comments = [];
        foreach ($result as $commentData) {
            if (!empty($commentData['postId'])) {
                $comment = new MainComment($commentData);
            } else {
                $comment = new ResponseComment($commentData);
            }
            $comments[] = $comment;
        }

        return $comments;
    }

    /**
     * Retrieves a comment by its ID from the database.
     *
     * @param int $id The ID of the comment to retrieve.
     * @return Comment The Comment object corresponding to the provided ID.
     */
    public function get($id)
    {
        $query = "
        SELECT 
            *
        FROM 
            comment 
        WHERE
            id = :id
        ";

        $params = [":id" => $id];
        $result = DbConnect::executeQuery($query, $params);

        return new Comment($result[0]);

    }

    /**
     * Creates a new comment in the database.
     *
     * @return bool True if the comment creation is successful, otherwise false.
     */
    public function create()
    {
        $textComment = filter_input(INPUT_POST, "textComment", FILTER_SANITIZE_STRING);
        $postId = filter_input(INPUT_POST, "postId", FILTER_VALIDATE_INT);
        
        if ($textComment === null || $postId === null) {
            $this->sessionManager->setSessionVariable("error_message", "Error submitting comment.");
            header("Location: ".BASE_URL."$postId");
            return;
        }
        
        $query="
            INSERT 
            INTO
                comment (text, date, status, postId, userId)
            VALUES
                (:text, NOW(), :status, :postId, :userId)
        ";
    
        $params = [
            ":text" => $textComment,
            ":status" => "pending",
            ":postId" => $postId,
            ":userId" => $this->sessionManager->getSessionVariable("userId")
        ];
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result === false) {
            $this->sessionManager->setSessionVariable("error_message", "Error submitting comment.");
            header("Location: ".BASE_URL."$postId");
            return;
        }
        return true;
    }

    /**
     * Approves a comment by updating its status in the database.
     *
     * @param int $id The ID of the comment to approve.
     * @return void
     */
    public function approve($id)
    {
        $query="
        UPDATE
            comment
        SET
            status = 'approved'
        WHERE
            id = :id
        ";

        $params = [":id" => $id];

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $this->sessionManager->setSessionVariable("success_message", "Comment approved.");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error when approving the comment.");
        }
        header("Location: ".BASE_URL."admin/commentsManagement");
    }
    
    /**
     * Deletes a comment from the database.
     *
     * @param int $id The ID of the comment to delete.
     * @return void
     */
    public function delete($id)
    {
        $query="
            DELETE
            FROM
                comment
            WHERE
            id = :id
        ";

        $params = [":id" => $id];

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $this->sessionManager->setSessionVariable("success_message", "Comment deleted !");
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error when deleting the comment.");
        }
        if (strstr($_SERVER['REQUEST_URI'], '/OC5/admin/commentsManagement')) {
            header("Location: ".BASE_URL."admin/commentsManagement");
        } else {
            header("Location: ".BASE_URL."user/comments");
        }
        return;
    }
}
