<?php

namespace application\src\models\comment;

use application\src\models\database\DbConnect;
use application\src\models\comment\MainComment;

class MainCommentManager
{
    public static function getAll(){
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

        $result = Model\database\DbConnect::executeQuery($query);

        $mainComments = [];

        foreach ($result as $mainComment) {
            $mainComments[] = new MainComment($mainComment);
        }
        return $mainComments;

    }

    public static function getAllByPostId($postId){
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

    public static function getAllApprovedByPostId($postId){
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
    
    public function create($commentId){
        $postId = filter_var($_POST["postId"], FILTER_VALIDATE_INT);
    
        if (empty($postId)) {
            $_SESSION["error_message"] = "Error submitting comment.";
            header("Location: http://localhost/OC5/");
            exit();
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
            $_SESSION["success_message"] = "Comment submitted.";
            header("Location: http://localhost/OC5/post/$postId");
            exit();
        } else {
            $_SESSION["error_message"] = "Error submitting comment.";
            header("Location: http://localhost/OC5/$postId");
            exit();
        }
    }
    
    
}
