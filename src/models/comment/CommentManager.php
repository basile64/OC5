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

            FROM 
                comment AS C
            LEFT JOIN 
                MainComment AS MC ON C.idComment = MC.idComment
            LEFT JOIN 
                responseComment AS RC ON C.idComment = RC.idComment
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
                RC.idMainComment

            FROM 
                comment AS C
            LEFT JOIN 
                MainComment AS MC ON C.idComment = MC.idComment
            LEFT JOIN 
                responseComment AS RC ON C.idComment = RC.idComment
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
    
    public function getAllApprovedByUser(){
        $query = "
            SELECT 
                C.idComment,
                C.dateComment,
                C.textComment,
                C.statusComment,
                C.idPost,
                C.idUser,
                RC.idMainComment

            FROM 
                comment AS C
            LEFT JOIN 
                MainComment AS MC ON C.idComment = MC.idComment
            LEFT JOIN 
                responseComment AS RC ON C.idComment = RC.idComment
            WHERE
                C.statusComment = 'approved' AND C.idUser = :idUser
            ORDER BY
                C.dateComment DESC
        ";

        $params= [
            ":idUser" => $_SESSION["idUser"]
        ];

        $result = DbConnect::executeQuery($query, $params);

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
            *
        FROM 
            comment 
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
                comment (textComment, dateComment, statusComment, idPost, idUser)
            VALUES
                (:textComment, NOW(), :statusComment, :idPost,:idUser)
        ";

        var_dump($newComment);

        $params = [
            ":textComment" => $newComment["textComment"],
            ":statusComment" => "pending",
            ":idPost" => $newComment["idPost"],
            ":idUser" => $_SESSION["idUser"]
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
            $_SESSION["success_message"] = "Comment deleted !";
        } else {
            $_SESSION["error_message"] = "Error when deleting the comment.";
        }
        if ($_SERVER['REQUEST_URI'] === '/OC5/admin/commentsManagement') {
            header("Location: http://localhost/OC5/admin/commentsManagement");
        } else {
            header("Location: http://localhost/OC5/user/comments");
        }
        exit();
    }
}
