<?php

namespace application\src\models\comment;

use application\src\models\database\DbConnect;
use application\src\models\comment\MainComment;
use application\src\models\comment\ResponseComment;

class ResponseCommentManager {

    public static function getAll(){
        $query = "
            SELECT
                responseComment.idResponseComment,
                responseComment.idMainComment,
                comment.idComment,
                comment.textComment,
                comment.statusComment,
                user.firstNameUser as authorComment,
                comment.dateComment
            FROM 
                responseComment
            JOIN 
                mainComment ON mainComment.idMainComment = responseComment.idMainComment
            JOIN 
                comment ON comment.idComment = responseComment.idComment
            JOIN 
                user ON user.idUser = comment.idUser
            ORDER BY 
                dateComment DESC;
        ";

        $result = DbConnect::executeQuery($query);

        $responseComments = [];

        foreach ($result as $responseComment) {
            $responseComments[] = new ResponseComment($responseComment);
        }
        return $responseComments;

    }

    public static function getAllByIdMainComment($idMainComment){
        $query = "
            SELECT
                responseComment.idResponseComment,
                responseComment.idMainComment,
                comment.idComment,
                comment.textComment,
                comment.statusComment,
                user.firstNameUser as authorComment,
                user.idUser,
                comment.dateComment
            FROM 
                responseComment
            JOIN 
                mainComment ON mainComment.idMainComment = responseComment.idMainComment
            JOIN 
                comment ON comment.idComment = responseComment.idComment
            JOIN 
                user ON user.idUser = comment.idUser
            WHERE
                mainComment.idMainComment = :idMainComment
            ORDER BY 
                dateComment DESC;
        ";


        $params = [":idMainComment" => $idMainComment];

        $result = DbConnect::executeQuery($query, $params);

        $responseComments = [];

        foreach ($result as $responseComment) {
            $responseComments[] = new ResponseComment($responseComment);
        }
        return $responseComments;
    }

    public static function getAllApprovedByIdMainComment($idMainComment){
        $query = "
            SELECT
                responseComment.idResponseComment,
                responseComment.idMainComment,
                comment.idComment,
                comment.textComment,
                comment.statusComment,
                user.firstNameUser as authorComment,
                user.idUser,
                comment.dateComment
            FROM 
                responseComment
            JOIN 
                mainComment ON mainComment.idMainComment = responseComment.idMainComment
            JOIN 
                comment ON comment.idComment = responseComment.idComment
            JOIN 
                user ON user.idUser = comment.idUser
            WHERE
                mainComment.idMainComment = :idMainComment AND comment.statusComment = 'approved'
            ORDER BY 
                dateComment DESC;
        ";


        $params = [":idMainComment" => $idMainComment];

        $result = DbConnect::executeQuery($query, $params);

        $responseComments = [];

        foreach ($result as $responseComment) {
            $responseComments[] = new ResponseComment($responseComment);
        }
        return $responseComments;
    }

    public function addResponseComment($idComment){
        $newComment = array_map("htmlspecialchars", $_POST);

        $query="
            INSERT 
            INTO
                responseComment (idComment, idMainComment)
            VALUES
                (:idComment, :idMainComment)
        ";

        $params = [
            ":idComment" => $idComment,
            ":idMainComment" => $newComment["idMainComment"],
        ];

        $result = DbConnect::executeQuery($query, $params);

        $idPost = $newComment["idPost"];

        if ($result !== false) {
            $_SESSION["success_message"] = "Comment submitted.";
            header("Location: http://localhost/OC5/post/$idPost");
            exit();
        } else {
            echo "Error submitting comment.";
        }
    }
}