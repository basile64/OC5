<?php

namespace application\src\models\post;

use application\src\controllers as Controller;
use application\src\models\database\DbConnect;

class PostManager {

    public function getAll(){
        $query = "
            SELECT
                post.idPost,
                post.titlePost,
                post.chapoPost,
                post.textPost,
                post.dateCreationPost,
                post.dateModificationPost,
                category.nameCategory as categoryPost,
                user.firstNameUser as authorPost
            FROM 
                post
            JOIN 
                user ON user.idUser = post.idUser
            JOIN 
                category ON category.idCategory = post.idCategory
            ORDER BY 
                post.dateCreationPost DESC
        ";
        

        $result = DbConnect::executeQuery($query);

        $posts = [];

        foreach ($result as $post) {
            $posts[] = new Post($post);
        }
        return $posts;
     
    }

    public function getPost($idPost){
        $query = "
            SELECT
                idPost,
                titlePost,
                chapoPost,
                textPost,
                dateCreationPost,
                dateModificationPost,
                category.nameCategory as categoryPost,
                user.firstNameUser as authorPost
            FROM 
                post
            JOIN 
                user ON user.idUser = post.idUser
            JOIN 
                category ON category.idCategory = post.idCategory
            WHERE 
                idPost = :idPost
        ";

        $params = [":idPost" => $idPost];
        $result = DbConnect::executeQuery($query, $params);

        return new Post($result[0]);

    }

    public function editPost($idPost){
        return ($this->getPost($idPost));
    }

    public function updatePost($idPost){
        $query ="
            UPDATE
                post
            SET
                titlePost = :titlePost,
                chapoPost = :chapoPost,
                textPost = :textPost,
                dateModificationPost = NOW()
            WHERE
                idPost = :idPost
        ";

        if (isset($_POST)){
        $params = [":titlePost" => $_POST["input-title"], ":chapoPost" => $_POST["textarea-chapo"], ":textPost" => $_POST["textarea-text"],":idPost" => $idPost];
        }

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $_SESSION["success_message"] = "Post modifié avec succès.";
            header("Location: http://localhost/OC5/admin/postsManagement");
            exit();
        } else {
            echo "Erreur lors de la modification du post.";
        }
    }

    public function deletePost($idPost){
        $query="
            DELETE
            FROM
                post
            WHERE
                idPost = :idPost
        ";

        $params = [":idPost" => $idPost];

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $_SESSION["success_message"] = "Post supprimé avec succès.";
            header("Location: http://localhost/OC5/admin/postsManagement");
            exit();
        } else {
            echo "Erreur lors de la suppression du post.";
        }
    }

    public function newPost(){
        //Pas besoin de retourner une variable, la vue nous suffit
        return null;
    }

    public function addPost(){
        $newPost = array_map("htmlspecialchars", $_POST);

        $query="
            INSERT 
            INTO
                post (titlePost, chapoPost, textPost, dateCreationPost, idUser, idCategory)
            VALUES (:titlePost, :chapoPost, :textPost, NOW(), :idUser, :idCategory)
        ";

        var_dump($_POST);

        $params = [
            ":titlePost" => $newPost["titlePost"],
            ":chapoPost" => $newPost["chapoPost"],
            ":textPost" => $newPost["textPost"],
            ":idUser" => $newPost["idUser"],
            ":idCategory" => $newPost["idCategory"]
        ];

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $_SESSION["success_message"] = "Post créé avec succès.";
            header("Location: http://localhost/OC5/admin/postsManagement");
            exit();
        } else {
            echo "Erreur lors de la création du post.";
        }
    }

}