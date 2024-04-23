<?php

namespace application\src\models\comment;

use application\src\models\database\DbConnect;
use application\src\models\comment\MainComment;
use application\src\models\comment\ResponseComment;

class ResponseCommentManager 
{
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
                comment.date as date,
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
                comment.date as date,
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

    public function create($commentId)
    {
        $postId = filter_var($_POST["postId"], FILTER_VALIDATE_INT);
        $mainCommentId = filter_var($_POST["mainCommentId"], FILTER_VALIDATE_INT);
    
        if (empty($postId) || empty($mainCommentId)) {
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
            header("Location: http://localhost/OC5/post/$postId");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error submitting comment.");
            header("Location: http://localhost/OC5/$postId");
            return;
        }
    }
    
}