<?php

namespace application\src\models\post;

use application\src\controllers as Controller;
use application\src\models\database\DbConnect;
use application\src\models\category\CategoryManager;
use application\src\models\user\UserManager;

class PostManager
{
    public static function getAll(){
        $query = "
        SELECT
            *,
            IFNULL(dateModification, dateCreation) AS date
        FROM 
            post
        ORDER BY 
            date DESC    
        ";
        

        $result = DbConnect::executeQuery($query);

        $posts = [];

        foreach ($result as $post) {
            $posts[] = new Post($post);
        }
        return $posts;
     
    }

    public function get($postId){
        $query = "
            SELECT
                *
            FROM 
                post
            WHERE 
                id = :postId
        ";

        $params = [":postId" => $postId];
        $result = DbConnect::executeQuery($query, $params);

        return new Post($result[0]);

    }

    public function edit($postId){
        return ($this->get($postId));
    }

    public function update($postId){
        $title = filter_var($_POST["postTitle"], FILTER_SANITIZE_STRING);
        $chapo = filter_var($_POST["postChapo"], FILTER_SANITIZE_STRING);
        $text = filter_var($_POST["postText"], FILTER_SANITIZE_STRING);
        $categoryId = filter_var($_POST["categoryId"], FILTER_VALIDATE_INT);
    
        if (empty($title) || empty($chapo) || empty($text) || empty($categoryId)) {
            $_SESSION["error_message"] = "All the fields are required.";
            header("Location: http://localhost/OC5/admin/postsManagement/edit/".$postId);
            exit();
        }
    
        $params = [
            ":title" => $title,
            ":chapo" => $chapo,
            ":text" => $text,
            ":categoryId" => $categoryId,
            ":postId" => $postId
        ];
    
        $query = "
            UPDATE
                post
            SET
                title = :title,
                chapo = :chapo,
                text = :text,
                dateModification = NOW(),
                categoryId = :categoryId
        ";
    
        if (isset($_FILES["postImg"]) && $_FILES["postImg"]["error"] === UPLOAD_ERR_OK){
            $uploadDir = "../public/upload/";
            $uploadFile = $uploadDir . basename($_FILES["postImg"]["name"]);
    
            if (move_uploaded_file($_FILES["postImg"]["tmp_name"], $uploadFile)){
                $imageName = basename($_FILES["postImg"]["name"]);
                $query .= ", img = :postImg";
                $params[":postImg"] = $imageName;
            } else {
                $_SESSION["error_message"] = "Error when uploading the image.";
                header("Location: http://localhost/OC5/admin/postsManagement/edit/".$postId);
                exit();
            }
        }

        $query .= " WHERE id = :postId";
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result !== false) {
            $_SESSION["success_message"] = "Post updated !";
            header("Location: http://localhost/OC5/admin/postsManagement");
            exit();
        } else {
            $_SESSION["error_message"] = "Error creating the post.";
            header("Location: http://localhost/OC5/admin/postsManagement/edit/".$postId);
            exit();
        }
    }
    
    
    public function delete($postId){
        $query="
            DELETE
            FROM
                post
            WHERE
                id = :postId
        ";

        $params = [":postId" => $postId];

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $_SESSION["success_message"] = "Post supprimé avec succès.";
            header("Location: http://localhost/OC5/admin/postsManagement");
            exit();
        } else {
            echo "Erreur lors de la suppression du post.";
        }
    }

    public function new(){
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getAll();
        return $categories;
    }

    public function create(){
        $newPost = $_POST;
    
        $title = filter_var($newPost["postTitle"], FILTER_SANITIZE_STRING);
        $chapo = filter_var($newPost["postChapo"], FILTER_SANITIZE_STRING);
        $text = filter_var($newPost["postText"], FILTER_SANITIZE_STRING);
        $userId = filter_var($newPost["userId"], FILTER_VALIDATE_INT);
        $categoryId = filter_var($newPost["categoryId"], FILTER_VALIDATE_INT);
    
        if (isset($_FILES["postImg"]) && $_FILES['postImg']['error'] === UPLOAD_ERR_OK){
            $uploadDir = "../public/upload/";
            $uploadFile = $uploadDir . basename($_FILES["postImg"]["name"]);
    
            if (move_uploaded_file($_FILES["postImg"]["tmp_name"], $uploadFile)){
                $imageName = basename($_FILES['postImg']['name']); 
    
                $query="
                    INSERT INTO
                        post (title, chapo, text, img, dateCreation, userId, categoryId)
                    VALUES (:title, :chapo, :text, :img, NOW(), :userId, :categoryId)
                ";
    
                $params = [
                    ":title" => $title,
                    ":chapo" => $chapo,
                    ":text" => $text,
                    ":img" => $imageName, 
                    ":userId" => $userId,
                    ":categoryId" => $categoryId
                ];
    
                $result = DbConnect::executeQuery($query, $params);
    
                if ($result !== false) {
                    $_SESSION["success_message"] = "Post created.";
                    unset($_SESSION['formData']);
                    header("Location: http://localhost/OC5/admin/postsManagement");
                    exit();
                } else {
                    $_SESSION["error_message"] = "Error when creating the post.";
                    $_SESSION["formData"] = $newPost;
                    header("Location: http://localhost/OC5/admin/postsManagement/new");
                    exit();
                }
            } else {
                $_SESSION["error_message"] = "Error when uploading the image.";
                $_SESSION["formData"] = $newPost;
                header("Location: http://localhost/OC5/admin/postsManagement/new");
                exit();
            }
        } else {
            $_SESSION["error_message"] = "Error when uploading the image.";
            $_SESSION["formData"] = $newPost;
            header("Location: http://localhost/OC5/admin/postsManagement/new");
            exit();
        }
    }
    
    public function getCategoryByPost($postId){
        $query = "
            SELECT
                idCategory
            FROM 
                post
            WHERE 
                id = :postId
        ";

        $params = [":postId" => $postId];
        $result = DbConnect::executeQuery($query, $params);

        $categoryId = $result[0]["idCategory"];

        $categoryManager = new CategoryManager;
        $category = $categoryManager::getCategory($categoryId);

        return $category->getName();
    }

    public function getAuthorByPost($postId){
        $query = "
            SELECT
                userId
            FROM 
                post
            WHERE 
                id = :postId
        ";

        $params = [":postId" => $postId];
        $result = DbConnect::executeQuery($query, $params);

        $userId = $result[0]["userId"];

        $userManager = new UserManager;
        $user = $userManager->get($userId);

        return $user->getFirstName();
    }

    public function getNext($postId){
        $post = $this->get($postId);
        $dateCreationPost = $post->getDateCreation()->format("Y-m-d H:i:s");
        $dateModificationPost = $post->getDateModification();
        $dateCreationOuModification = ($dateModificationPost != null)? $dateModificationPost->format("Y-m-d H:i:s") : $dateCreationPost;

        $query = "
            SELECT
                *,
                IFNULL(dateModification, dateCreation) AS dateCreationOuModification
            FROM 
                post
            WHERE
                IFNULL(dateModification, dateCreation) < :dateCreationOuModification
                AND id != :postId
            ORDER BY
                dateCreationOuModification DESC
            LIMIT 1
        ";

        $params = [":dateCreationOuModification" => $dateCreationOuModification, ":postId" => $postId];
        $result = DbConnect::executeQuery($query, $params);

        $nextPost = new Post($result[0]);

        return $nextPost;
    }

    public function getPrevious($postId){
        $post = $this->get($postId);
        $dateCreationPost = $post->getDateCreation()->format("Y-m-d H:i:s");
        $dateModificationPost = $post->getDateModification();
        $dateCreationOuModification = ($dateModificationPost != null)? $dateModificationPost->format("Y-m-d H:i:s") : $dateCreationPost;

        $query = "
            SELECT
                *,
                IFNULL(dateModification, dateCreation) AS dateCreationOuModification
            FROM 
                post
            WHERE
                IFNULL(dateModification, dateCreation) > :dateCreationOuModification
                AND id != :postId
            ORDER BY
                dateCreationOuModification ASC
            LIMIT 1
        ";

        $params = [":dateCreationOuModification" => $dateCreationOuModification, ":postId" => $postId];
        $result = DbConnect::executeQuery($query, $params);

        $previousPost = new Post($result[0]);

        return $previousPost;
    }

}
