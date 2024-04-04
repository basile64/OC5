<?php

namespace application\src\models\post;

use application\src\controllers as Controller;
use application\src\models\database\DbConnect;
use application\src\models\category\CategoryManager;
use application\src\models\user\UserManager;

class PostManager {

    public static function getAll(){
        $query = "
            SELECT
                *
            FROM 
                post
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
                *
            FROM 
                post
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
        $query = "
            UPDATE
                post
            SET
                titlePost = :titlePost,
                chapoPost = :chapoPost,
                textPost = :textPost,
                dateModificationPost = NOW(),
                idCategory = :idCategory
        ";
    
        $params = [
            ":titlePost" => $_POST["titlePost"],
            ":chapoPost" => $_POST["chapoPost"],
            ":textPost" => $_POST["textPost"],
            ":idCategory" => $_POST["idCategory"]
        ];
    
        if (isset($_FILES["imgPost"]) && $_FILES["imgPost"]["error"] === UPLOAD_ERR_OK){
            $uploadDir = "../public/upload/";
            $uploadFile = $uploadDir . basename($_FILES["imgPost"]["name"]);
    
            if (move_uploaded_file($_FILES["imgPost"]["tmp_name"], $uploadFile)){
                $imageName = basename($_FILES["imgPost"]["name"]);
                $query .= ", imgPost = :imgPost";
                $params[":imgPost"] = $imageName;
            } else {
                echo "Erreur lors de l'upload de l'image.";
                return; 
            }
        }
    
        $query .= " WHERE idPost = :idPost";
        $params[":idPost"] = $idPost;
    
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
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getAll();
        return $categories;
    }

    public function createPost(){
        if (isset($_FILES["imgPost"]) && $_FILES['imgPost']['error'] === UPLOAD_ERR_OK){
            $uploadDir = "../public/upload/";
            $uploadFile = $uploadDir . basename($_FILES["imgPost"]["name"]);

            if (move_uploaded_file($_FILES["imgPost"]["tmp_name"], $uploadFile)){
                $newPost = array_map("htmlspecialchars", $_POST);
                $imageName = basename($_FILES['imgPost']['name']); 

                $query="
                    INSERT INTO
                        post (titlePost, chapoPost, textPost, imgPost, dateCreationPost, idUser, idCategory)
                    VALUES (:titlePost, :chapoPost, :textPost, :imgPost, NOW(), :idUser, :idCategory)
                ";

                $params = [
                    ":titlePost" => $newPost["titlePost"],
                    ":chapoPost" => $newPost["chapoPost"],
                    ":textPost" => $newPost["textPost"],
                    ":imgPost" => $imageName, 
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
            } else {
                echo "Erreur lors de l'upload de l'image.";
            }
        } else {
            echo "Aucun fichier n'a été téléchargé ou une erreur est survenue lors de l'upload.";
        }
    }

    public function getCategoryByPost($idPost){
        $query = "
            SELECT
                idCategory
            FROM 
                post
            WHERE 
                idPost = :idPost
        ";

        $params = [":idPost" => $idPost];
        $result = DbConnect::executeQuery($query, $params);

        $idCategory = $result[0]["idCategory"];

        $categoryManager = new CategoryManager;
        $category = $categoryManager::getCategory($idCategory);

        return $category->getName();
    }

    public function getAuthorByPost($idPost){
        $query = "
            SELECT
                idUser
            FROM 
                post
            WHERE 
                idPost = :idPost
        ";

        $params = [":idPost" => $idPost];
        $result = DbConnect::executeQuery($query, $params);

        $idCategory = $result[0]["idCategory"];

        $userManager = new UserManager;
        $user = $userManager::getUser($idUser);

        return $user->getFirstName();
    }

}