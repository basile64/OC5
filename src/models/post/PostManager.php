<?php

namespace application\src\models\post;

use application\src\controllers as Controller;
use application\src\models\database\DbConnect;
use application\src\models\category\CategoryManager;
use application\src\models\user\UserManager;
use application\src\utils\SessionManager;

class PostManager
{

    public $sessionManager;

    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }
    
    public function getAll(){
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
        $title = filter_input(INPUT_POST, 'postTitle', FILTER_SANITIZE_STRING);
        $chapo = filter_input(INPUT_POST, 'postChapo', FILTER_SANITIZE_STRING);
        $text = filter_input(INPUT_POST, 'postText', FILTER_SANITIZE_STRING);
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT);
        
    
        if ($title === null || $chapo === null || $text === null || $categoryId === null) {
            $this->sessionManager->setSessionVariable("error_message", "All the fields are required.");
            header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
            return;
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
                $this->sessionManager->setSessionVariable("error_message", "Error when uploading the image.");
                header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
                return;
            }
        }

        $query .= " WHERE id = :postId";
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result !== false) {
            $this->sessionManager->setSessionVariable("success_message", "Post updated !");
            header("Location: ".BASE_URL."admin/postsManagement");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error creating the post.");
            header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
            return;
        }
    }
    
    
    public function delete($postId)
    {
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
            $this->sessionManager->setSessionVariable("success_message", "Post supprimé avec succès.");
            header("Location: ".BASE_URL."admin/postsManagement");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error when deleting the post.");
            header("Location: ".BASE_URL."admin/postsManagement");
            return;
        }
    }

    public function new()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getAll();
        return $categories;
    }

    public function create()
    {
        $title = filter_input(INPUT_POST, "postTitle", FILTER_SANITIZE_STRING);
        $chapo = filter_input(INPUT_POST, "postChapo", FILTER_SANITIZE_STRING);
        $text = filter_input(INPUT_POST, "postText", FILTER_SANITIZE_STRING);
        $userId = filter_input(INPUT_POST, "userId", FILTER_VALIDATE_INT);
        $categoryId = filter_input(INPUT_POST, "categoryId", FILTER_VALIDATE_INT);

        if ($title === null || $chapo === null || $text === null || $userId === null || $categoryId === null) {
            $this->sessionManager->setSessionVariable("error_message", "All the fields are required.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".BASE_URL."admin/postsManagement/create");
            return;
        }
    
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
                    $this->sessionManager->setSessionVariable("success_message", "Post created.");
                    $this->sessionManager->unsetSessionVariable("formData");
                    header("Location: ".BASE_URL."admin/postsManagement");
                    return;
                } else {
                    $this->sessionManager->setSessionVariable("error_message", "Error when creating the post.");
                    $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
                    header("Location: ".BASE_URL."admin/postsManagement/new");
                    return;
                }
            } else {
                $this->sessionManager->setSessionVariable("error_message", "Error when uploading the image.");
                $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
                header("Location: ".BASE_URL."admin/postsManagement/new");
                return;
            }
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error when uploading the image.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".BASE_URL."admin/postsManagement/new");
            return;
        }
    }
    
    public function getCategoryByPost($postId)
    {
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
        $category = $categoryManager->getCategory($categoryId);

        return $category->getName();
    }

    public function getAuthorByPost($postId)
    {
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

    public function getNext($postId)
    {
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

    public function getPrevious($postId)
    {
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
