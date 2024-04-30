<?php

namespace application\src\models\post;

use application\src\controllers as Controller;
use application\src\models\database\DbConnect;
use application\src\models\category\CategoryManager;
use application\src\models\user\UserManager;
use application\src\utils\SessionManager;
use application\src\models\file\FileManager;
use application\src\models\file\File;

/**
 * Provides methods to manage post entity.
 */
class PostManager
{

    /**
     * @var UserManager The user manager instance.
     */
    protected $userManager;

    /**
     * @var CategoryManager The category manager instance.
     */
    protected $categoryManager;

    /**
     * @var SessionManager The session manager instance.
     */
    protected $sessionManager;

    /**
     * @var FileManager The file manager instance.
     */
    protected $fileManager;

    /**
     * PostManager constructor.
     */
    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }
    
    /**
     * Retrieves all posts from the database.
     *
     * @return array An array of Post objects.
     */
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

    /**
     * Retrieves a post by its ID.
     *
     * @param int $postId The ID of the post.
     * @return Post|null The post object, or null if not found.
     */
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

    /**
     * Retrieves a post to edit by its ID.
     *
     * @param int $postId The ID of the post.
     * @return Post|null The post object, or null if not found.
     */
    public function edit($postId)
    {
        return ($this->get($postId));
    }

    /**
     * Updates a post in the database.
     *
     * @param int $postId The ID of the post to update.
     */
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
    
        // Check if a file has been submitted
        if ($this->fileManager->isFileUploaded("postImg") === true) {
            $imgFile = new File("postImg");

            // Check if the file exists 
            if ($this->fileManager->fileExists("postImg") === false) {
                $this->sessionManager->setSessionVariable("error_message", "Image doesn't exist.");
                header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
                return;
            }

            // Check if the file is an image by checking its extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if ($this->fileManager->isAllowedFileType($imgFile, $allowedExtensions) === false) {
                $this->sessionManager->setSessionVariable("error_message", "Only JPG, JPEG, PNG, and GIF files are allowed.");
                header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
                return;
            }
            
            // Upload the file
            $uploadDir = "../public/upload/";
            $fileName = $this->fileManager->generateUniqueFilename($imgFile->getName()); // Use the method to generate a unique name
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
    
    /**
     * Deletes a post from the database by its ID.
     *
     * @param int $postId The ID of the post to delete.
     */
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

    /**
     * Retrieves all categories.
     *
     * @return array An array of categories.
     */
    public function new()
    {
        $this->categoryManager = new CategoryManager();
        $categories = $this->categoryManager->getAll();
        return $categories;
    }

    /**
     * Creates a new post in the database.
     */
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
    
        // Create an instance of FileManager
        $this->fileManager = new FileManager;
        
        // Check if a file has been submitted
        if ($this->fileManager->isFileUploaded("postImg") === true) {
            // Retrieve the File instance for the image
            $imgFile = new File("postImg");

            // Check if the file exists 
            if ($this->fileManager->fileExists("postImg") === false) {
                $this->sessionManager->setSessionVariable("error_message", "Image doesn't exist.");
                header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
                return;
            }

            // Check if the file is an image by checking its extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if ($this->fileManager->isAllowedFileType($imgFile, $allowedExtensions) === false) {
                $this->sessionManager->setSessionVariable("error_message", "Only JPG, JPEG, PNG, and GIF files are allowed.");
                header("Location: ".BASE_URL."admin/postsManagement/edit/".$postId);
                return;
            }
            
            // Upload the file
            $uploadDir = "../public/upload/";
            $fileName = $this->fileManager->generateUniqueFilename($imgFile->getName());
            if (!$this->fileManager->moveUploadedFile($imgFile, $uploadDir, $fileName)) {
                $this->sessionManager->setSessionVariable("error_message", "Error when uploading the image.");
                $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
                header("Location: " . BASE_URL . "admin/postsManagement/create");
                return;
            }
            
            // Add the file name to the SQL query
            $params[":img"] = $fileName;
        } else {
            // Add a NULL value for the image if no file has been uploaded
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

    /**
     * Retrieves the category of a post by its ID.
     *
     * @param int $postId The ID of the post.
     * @return string The name of the category.
     */
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

    /**
     * Retrieves the author of a post by its ID.
     *
     * @param int $postId The ID of the post.
     * @return string The first name of the author.
     */
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

    /**
     * Retrieves the next post based on the given post ID.
     *
     * @param int $postId The ID of the current post.
     * @return Post The next post.
     */
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

    /**
     * Retrieves the previous post based on the given post ID.
     *
     * @param int $postId The ID of the current post.
     * @return Post|null The previous post, or null if none found.
     */
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
                IFNULL(dateModification, dateCreation) < :dateCreationOuModification
                AND id != :postId
            ORDER BY
                dateCreationOuModification DESC
            LIMIT 1
        ";

        $params = [":dateCreationOuModification" => $dateCreationOuModification, ":postId" => $postId];
        $result = DbConnect::executeQuery($query, $params);

        if (!empty($result)) {
            $previousPost = new Post($result[0]);
            return $previousPost;
        } else {
            return null; // Return null if no previous post found
        }
    }
}

