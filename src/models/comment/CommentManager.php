<?php

namespace application\src\models\comment;

use application\src\models\comment\Comment;
use application\src\models\database\DbConnect;
use application\src\utils\SessionManager;

class CommentManager
{

    private $sessionManager;

    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }

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
                RC.mainCommentId,

            FROM 
                comment AS C
            LEFT JOIN 
                mainComment AS MC ON C.id = MC.commentId
            LEFT JOIN 
                responseComment AS RC ON C.id = RC.commentId
        ";

        $result = DbConnect::executeQuery($query);

        // Instanciation des commentaires en fonction du type
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

        // Instanciation des commentaires en fonction du type
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

        // Instanciation des commentaires en fonction du type
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
    
        if ($result !== false) {
            return true;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error submitting comment.");
            header("Location: ".BASE_URL."$postId");
            return;
        }
    }
    

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
        exit();
    }
}
