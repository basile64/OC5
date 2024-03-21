<?php

namespace application\src\models\comment;

use application\src\models\database\DbConnect;
use application\src\models\comment\MainComment;

class MainCommentManager {

    public static function getAll(){
        $query = "
            SELECT
                comment.idComment,
                comment.textComment,
                comment.statusComment,
                user.firstNameUser as authorComment,
                DATE_FORMAT(comment.dateComment, '%d/%m/%Y') AS dateComment,
                post.idPost as idPost
            FROM 
                comment
            JOIN 
                user ON user.idUser = comment.idUser
            JOIN
                mainComment ON mainComment.idComment = comment.idComment
            JOIN
                post ON post.idPost = comment.idPost
            ORDER BY 
                dateComment DESC
        ";

        $result = Model\database\DbConnect::executeQuery($query);

        $mainComments = [];

        foreach ($result as $mainComment) {
            $mainComments[] = new MainComment($mainComment);
        }
        return $mainComments;

    }

    public static function getAllByIdPost($idPost){
        $query = "
            SELECT
                comment.textComment,
                comment.statusComment,
                comment.dateComment,
                mainComment.idComment,
                mainComment.idMainComment,
                user.firstNameUser as authorComment,
                post.idPost as idPost,
                user.idUser
            FROM 
                comment
            JOIN 
                user ON user.idUser = comment.idUser
            JOIN
                mainComment ON mainComment.idComment = comment.idComment
            JOIN
                post ON post.idPost = comment.idPost
            WHERE
                post.idPost = :idPost
            ORDER BY 
                dateComment DESC
        ";


        $params = [":idPost" => $idPost];

        $result = DbConnect::executeQuery($query, $params);

        $mainComments = [];

        foreach ($result as $mainComment) {
            $mainComments[] = new MainComment($mainComment);
        }
        return $mainComments;

    }

    public static function getAllApprovedByIdPost($idPost){
        $query = "
            SELECT
                comment.textComment,
                comment.statusComment,
                comment.dateComment,
                mainComment.idComment,
                mainComment.idMainComment,
                user.firstNameUser as authorComment,
                post.idPost as idPost,
                user.idUser
            FROM 
                comment
            JOIN 
                user ON user.idUser = comment.idUser
            JOIN
                mainComment ON mainComment.idComment = comment.idComment
            JOIN
                post ON post.idPost = comment.idPost
            WHERE
                post.idPost = :idPost AND comment.statusComment = 'Approved'
            ORDER BY 
                dateComment DESC
        ";


        $params = [":idPost" => $idPost];

        $result = DbConnect::executeQuery($query, $params);

        $mainComments = [];

        foreach ($result as $mainComment) {
            $mainComments[] = new MainComment($mainComment);
        }
        return $mainComments;

    }
    

    public function createMainComment($idComment){
        $newComment = array_map("htmlspecialchars", $_POST);
        $idPost = $newComment["idPost"];

        $query="
            INSERT 
            INTO
                mainComment (idComment)
            VALUES
                (:idComment)
        ";

        $params = [
            ":idComment" => $idComment
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
