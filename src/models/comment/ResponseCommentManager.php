<?php

namespace application\src\models\comment;

use application\src\controllers as Controller;
use application\src\models as Model;

class ResponseCommentManager {

    public static function getResponseComments($idMainComment){
        $query = "
            SELECT
                responseComment.idResponseComment,
                responseComment.idMainComment,
                comment.idComment,
                comment.textComment,
                comment.statusComment,
                user.firstNameUser as authorComment,
                DATE_FORMAT(comment.dateComment, '%d/%m/%Y') AS dateComment
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

        $result = Model\database\DbConnect::executeQuery($query, $params);

        $responseComments = [];

        if (is_array($result)) {
            foreach ($result as $responseComment) {
                $responseComments[] = new ResponseComment($responseComment);
            }
            return $responseComments;
        }        

        return null;
    }
}