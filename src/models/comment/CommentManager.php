<?php

namespace application\src\models\comment;

use application\src\controllers as Controller;
use application\src\models as Model;

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

        $result = Model\database\DbConnect::executeQuery($query, $params);

        $comments = [];

        if (is_array($result)) {
            foreach ($result as $comment) {
                $comments[] = new Comment($comment);
            }
            return $comments;
        }        

        return null;
    }
}