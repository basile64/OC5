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
                C.idComment,
                C.dateComment,
                C.textComment,
                C.statusComment,
                C.idPost,
                C.idUser,
                RC.idMainComment,
                U.firstNameUser as authorComment

            FROM 
                comment AS C
            LEFT JOIN 
                MainComment AS MC ON C.idComment = MC.idComment
            LEFT JOIN 
                responseComment AS RC ON C.idComment = RC.idComment
            JOIN
                user as U ON U.idUser = C.idUser;
        ";

        $result = DbConnect::executeQuery($query);

        // Instanciation des commentaires en fonction du type
        $comments = [];
        foreach ($result as $commentData) {
            if (!empty($commentData['idPost'])) {
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
                C.idComment,
                C.dateComment,
                C.textComment,
                C.statusComment,
                C.idPost,
                C.idUser,
                RC.idMainComment,
                U.firstNameUser as authorComment

            FROM 
                comment AS C
            LEFT JOIN 
                MainComment AS MC ON C.idComment = MC.idComment
            LEFT JOIN 
                responseComment AS RC ON C.idComment = RC.idComment
            JOIN
                user as U ON U.idUser = C.idUser
            WHERE
                C.statusComment = 'pending'
            ORDER BY
                C.dateComment DESC
        ";

        $result = DbConnect::executeQuery($query);

        // Instanciation des commentaires en fonction du type
        $comments = [];
        foreach ($result as $commentData) {
            if (!empty($commentData['idPost'])) {
                $comment = new MainComment($commentData);
            } else {
                $comment = new ResponseComment($commentData);
            }
            $comments[] = $comment;
        }

        return $comments;
    }

    public function getComment($idComment){
        $query = "
        SELECT 
            idComment,
            dateComment,
            textComment,
            statusComment,
            idPost,
            idUser,
            U.firstNameUser as authorComment
        FROM 
            comment 
        JOIN
            User ON user.idUser = comment.idUser;
        WHERE
            idComment = :idComment
        ";

        $params = [":idComment" => $idComment];
        $result = DbConnect::executeQuery($query, $params);

        return new Comment($result[0]);

    }

    public function createComment(){
        $newComment = array_map("htmlspecialchars", $_POST);

        $query="
            INSERT 
            INTO
                comment (textComment, dateComment, idUser, statusComment)
            VALUES
                (:textComment, NOW(), :idUser, :statusComment)
        ";

        $params = [
            ":textComment" => $newComment["textComment"],
            ":idUser" => 1,
            ":statusComment" => "pending"
        ];

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            return true;
        } else {
            echo "Error submitting comment.";
        }
    }

    public function approveComment($idComment){
        $query="
        UPDATE
            comment
        SET
            statusComment = 'approved'
        WHERE
            idComment = :idComment
        ";

        $params = [":idComment" => $idComment];

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $_SESSION["success_message"] = "Commentaire approuvé avec succès.";
            header("Location: http://localhost/OC5/admin/commentsManagement");
            exit();
        } else {
            echo "Erreur lors de l'approbation du commentaire.";
        }
    }
    
    public function deleteComment($idComment){
        $query="
            DELETE
            FROM
                comment
            WHERE
                idComment = :idComment
        ";

        $params = [":idComment" => $idComment];

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $_SESSION["success_message"] = "Commentaire supprimé avec succès.";
            header("Location: http://localhost/OC5/admin/commentsManagement");
            exit();
        } else {
            echo "Erreur lors de la suppression du commentaire.";
        }
    }
}
