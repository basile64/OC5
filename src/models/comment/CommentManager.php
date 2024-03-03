<?php

namespace application\src\models\comment;

class CommentManager {

    public static function getComments($idPost){
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
                post ON post.idPost = mainComment.idPost
            WHERE
                post.idPost = :idPost
            ORDER BY 
                dateComment DESC
        ";


        $params = [":idPost" => $idPost];

        $result = DbConnect::executeQuery($query, $params);

        return $result;
    }
}