<?php

namespace application\src\models\comment;

use application\src\models\database\DbConnect;
use application\src\models\comment\MainComment;
use application\src\utils\SessionManager;

class MainCommentManager
{

    public $sessionManager;

    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }

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

        $result = Model\database\DbConnect::executeQuery($query);

        $mainComments = [];

        foreach ($result as $mainComment) {
            $mainComments[] = new MainComment($mainComment);
        }
        return $mainComments;

    }

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
    
    public function create($commentId)
    {
        $postId = filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT);

        if ($postId === null) {
            $this->sessionManager->setSessionVariable("error_message", "Error submitting comment.");
            header("Location: ".htmlspecialchars(BASE_URL));
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
            header("Location: ".htmlspecialchars(BASE_URL)."post/$postId");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error submitting comment.");
            header("Location: ".htmlspecialchars(BASE_URL)."$postId");
            return;
        }
    }
    
    
}
