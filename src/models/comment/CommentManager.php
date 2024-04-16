<?php

namespace application\src\models\comment;

use application\src\models\comment\Comment;
use application\src\models\database\DbConnect;

class CommentManager {
    private $mainCommentManager;
    private $responseCommentManager;

    public function getAll(){
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

    public function getAllPending(){
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
    
    public function getAllApprovedByUser(){
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
            ":userId" => $_SESSION["userId"]
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

    public function get($id){
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

    public function create(){
        $textComment = filter_var($_POST["textComment"], FILTER_SANITIZE_STRING);
        $postId = filter_var($_POST["postId"], FILTER_VALIDATE_INT);
    
        if (empty($textComment) || empty($postId)) {
            $_SESSION["error_message"] = "Error submitting comment.";
            header("Location: http://localhost/OC5/$postId");
            exit();
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
            ":userId" => $_SESSION["userId"]
        ];
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result !== false) {
            return true;
        } else {
            $_SESSION["error_message"] = "Error submitting comment.";
            header("Location: http://localhost/OC5/$postId");
            exit();
        }
    }
    

    public function approve($id){
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
            $_SESSION["success_message"] = "Comment approved.";
            exit();
        } else {
            $_SESSION["error_message"] = "Error when approving the comment.";
        }
        header("Location: http://localhost/OC5/admin/commentsManagement");
    }
    
    public function delete($id){
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
            $_SESSION["success_message"] = "Comment deleted !";
        } else {
            $_SESSION["error_message"] = "Error when deleting the comment.";
        }
        if (strstr($_SERVER['REQUEST_URI'], '/OC5/admin/commentsManagement')) {
            header("Location: http://localhost/OC5/admin/commentsManagement");
        } else {
            header("Location: http://localhost/OC5/user/comments");
        }
        exit();
    }
}
