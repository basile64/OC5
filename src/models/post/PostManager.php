<?php

namespace application\src\models\post;

use application\src\controllers as Controller;
use application\src\models\database\DbConnect;
use application\src\models\category\CategoryManager;
use application\src\models\user\UserManager;
use application\src\utils\SessionManager;
use application\src\models\file\FileManager;
use application\src\models\file\File;

class PostManager
{

    protected $userManager;
    protected $categoryManager;
    protected $sessionManager;
    protected $fileManager;

    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }
    
    public function getAll()
    {
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

    public function get($postId)
    {
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

    public function edit($postId)
    {
        return ($this->get($postId));
    }

    public function update($postId)
    {
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
    
        $query = "UPDATE post SET title = :title, chapo = :chapo, text = :text, dateModification = NOW(), categoryId = :categoryId";
    
        $this->fileManager = new FileManager;
    
        // Vérifier si un fichier a été soumis
        if ($this->fileManager->isFileUploaded("postImg") === true) {
            $imgFile = new File("postImg");

            // Vérifier si le fichier existe 
            if ($this->fileManager->fileExists("postImg") === false) {
                $this->sessionManager->setSessionVariable("error_message", "Image doesn't exist.");
                header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
                return;
            }

            // Vérifier si le fichier est une image en vérifiant son extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if ($this->fileManager->isAllowedFileType($imgFile, $allowedExtensions) === false) {
                $this->sessionManager->setSessionVariable("error_message", "Only JPG, JPEG, PNG, and GIF files are allowed.");
                header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
                return;
            }
            
            // Télécharger le fichier
            $uploadDir = "../public/upload/";
            $fileName = $this->fileManager->generateUniqueFilename($imgFile->getName()); // Utilisez la méthode pour générer un nom unique
            if (!$this->fileManager->moveUploadedFile($imgFile, $uploadDir, $fileName)) {
                $this->sessionManager->setSessionVariable("error_message", "Unable to upload the image.");
                header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
                return;
            }
            
            $query .= ", img = :postImg";
            $params[":postImg"] = $fileName;
        }
    
        $query .= " WHERE id = :postId";
    
        $result = DbConnect::executeQuery($query, $params);
        
        if ($result === false) {
            $this->sessionManager->setSessionVariable("error_message", "Error updating the post.");
            header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
            return;
        }

        $this->sessionManager->setSessionVariable("success_message", "Post updated !");
        header("Location: ".BASE_URL."admin/postsManagement");
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
        $this->categoryManager = new CategoryManager();
        $categories = $this->categoryManager->getAll();
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
            header("Location: " . BASE_URL . "admin/postsManagement/create");
            return;
        }
    
        $params = [
            ":title" => $title,
            ":chapo" => $chapo,
            ":text" => $text,
            ":userId" => $userId,
            ":categoryId" => $categoryId
        ];
    
        $query = "INSERT INTO post (title, chapo, text, dateCreation, userId, categoryId, img)";
    
        // Créez une instance de FileManager
        $this->fileManager = new FileManager;
        
        // Vérifiez si un fichier a été soumis
        if ($this->fileManager->isFileUploaded("postImg") === true) {
            // Récupérez l'instance de File pour l'image
            $imgFile = new File("postImg");

            // Vérifier si le fichier existe 
            if ($this->fileManager->fileExists("postImg") === false) {
                $this->sessionManager->setSessionVariable("error_message", "Image doesn't exist.");
                header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
                return;
            }

            // Vérifier si le fichier est une image en vérifiant son extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if ($this->fileManager->isAllowedFileType($imgFile, $allowedExtensions) === false) {
                $this->sessionManager->setSessionVariable("error_message", "Only JPG, JPEG, PNG, and GIF files are allowed.");
                header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
                return;
            }
            
            // Téléchargez le fichier
            $uploadDir = "../public/upload/";
            $fileName = $this->fileManager->generateUniqueFilename($imgFile->getName());
            if (!$this->fileManager->moveUploadedFile($imgFile, $uploadDir, $fileName)) {
                $this->sessionManager->setSessionVariable("error_message", "Error when uploading the image.");
                $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
                header("Location: " . BASE_URL . "admin/postsManagement/create");
                return;
            }
            
            // Ajoutez le nom de fichier à la requête SQL
            $params[":img"] = $fileName;
        } else {
            // Ajoutez une valeur NULL pour l'image si aucun fichier n'a été téléchargé
            $params[":img"] = null;
        }
        
        $query .= "VALUES (:title, :chapo, :text, NOW(), :userId, :categoryId, :img)";
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result === false) {
            $this->sessionManager->setSessionVariable("error_message", "Error when creating the post.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: " . BASE_URL . "admin/postsManagement/new");
            return;
        }

        $this->sessionManager->setSessionVariable("success_message", "Post created.");
        $this->sessionManager->unsetSessionVariable("formData");
        header("Location: " . BASE_URL . "admin/postsManagement");
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

        $this->categoryManager = new CategoryManager;
        $category = $this->categoryManager->getCategory($categoryId);

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

        $this->userManager = new UserManager;
        $user = $this->userManager->get($userId);

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
