<?php

namespace application\src\models\post;

use application\src\models\user\UserManager;
use application\src\models\category\CategoryManager;
use application\src\models\comment\MainCommentManager;

/**
 * Represents a post entity.
 */
class Post
{
    /**
     * The column name for the post ID.
     */
    private const ID_COLUMN = 'id';

    /**
     * The column name for the post creation date.
     */
    private const DATE_CREATION_COLUMN = 'dateCreation';

    /**
     * The column name for the post modification date.
     */
    private const DATE_MODIFICATION_COLUMN = 'dateModification';

    /**
     * The column name for the post title.
     */
    private const TITLE_COLUMN = 'title';

    /**
     * The column name for the post chapo.
     */
    private const CHAPO_COLUMN = 'chapo';

    /**
     * The column name for the post text.
     */
    private const TEXT_COLUMN = 'text';

    /**
     * The column name for the post image.
     */
    private const IMG_COLUMN = 'img';

    /**
     * The column name for the user ID associated with the post.
     */
    private const USER_ID_COLUMN = 'userId';

    /**
     * The column name for the category ID associated with the post.
     */
    private const CATEGORY_ID_COLUMN = 'categoryId';

    /**
     * @var int|null The ID of the post.
     */
    private $id;

    /**
     * @var \DateTime|null The creation date of the post.
     */
    private $dateCreation;

    /**
     * @var \DateTime|null The modification date of the post.
     */
    private $dateModification;

    /**
     * @var string|null The title of the post.
     */
    private $title;

    /**
     * @var string|null The chapo of the post.
     */
    private $chapo;

    /**
     * @var string|null The text of the post.
     */
    private $text;

    /**
     * @var string|null The image URL of the post.
     */
    private $img;

    /**
     * @var int|null The ID of the user associated with the post.
     */
    private $userId;

    /**
     * @var int|null The ID of the category associated with the post.
     */
    private $categoryId;

    /**
     * Post constructor.
     * @param array $post The post data.
     */
    public function __construct($post)
    {
        $this->setId($post[self::ID_COLUMN] ?? null);
        $this->setDateCreation($post[self::DATE_CREATION_COLUMN] ?? null);
        $this->setDateModification($post[self::DATE_MODIFICATION_COLUMN] ?? null);
        $this->setTitle($post[self::TITLE_COLUMN] ?? null);
        $this->setChapo($post[self::CHAPO_COLUMN] ?? null);
        $this->setText($post[self::TEXT_COLUMN] ?? null);
        $this->setImg($post[self::IMG_COLUMN] ?? null);
        $this->setUserId($post[self::USER_ID_COLUMN] ?? null);
        $this->setCategoryId($post[self::CATEGORY_ID_COLUMN] ?? null);
    }

    //Getters
    /**
     * Gets the ID of the post.
     * @return int|null The ID of the post.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the creation date of the post.
     * @param string $format The date format.
     * @return \DateTime|null The creation date of the post.
     */
    public function getDateCreation($format = "Y-m-d")
    {
        return $this->dateCreation;
    }

    /**
     * Gets the modification date of the post.
     * @param string $format The date format.
     * @return \DateTime|null The modification date of the post.
     */
    public function getDateModification($format = "Y-m-d")
    {
        return $this->dateModification;
    }

    /**
     * Gets the title of the post.
     * @return string|null The title of the post.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Gets the chapo of the post.
     * @return string|null The chapo of the post.
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * Gets the text of the post.
     * @return string|null The text of the post.
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Gets the image URL of the post.
     * @return string|null The image URL of the post.
     */
    public function getImg()
    {
        return $this->img;
    }
        
    /**
     * Gets the user ID associated with the post.
     * @return int|null The user ID associated with the post.
     */
    public function getUserId()
    {
        return $this->userId;
    } 
    
    /**
     * Gets the user associated with the post.
     * @return mixed The user associated with the post.
     */
    public function getUser()
    {
        $userManager = new UserManager;
        $user = $userManager->get($this->userId);
        return $user;
    }

    /**
     * Gets the category ID associated with the post.
     * @return int|null The category ID associated with the post.
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Gets the main comments associated with the post.
     * @return array The main comments associated with the post.
     */
    public function getMainComments()
    {
        $mainCommentManager = new MainCommentManager;
        $mainComments = $mainCommentManager->getAllApprovedByPostId($this->id);
        return $mainComments;
    }

    //Setters
    /**
     * Sets the ID of the post.
     * @param int|null $id The ID of the post.
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Sets the creation date of the post.
     * @param string|null $dateCreation The creation date of the post.
     */
    private function setDateCreation($dateCreation)
    {
        if ($dateCreation != null){
            $this->dateCreation = new \DateTime($dateCreation);
        } else {
            $this->dateCreation = null;
        }
    }

    /**
     * Sets the modification date of the post.
     * @param string|null $dateModification The modification date of the post.
     */
    private function setDateModification($dateModification)
    {
        if ($dateModification != null){
            $this->dateModification = new \DateTime($dateModification);
        } else {
            $this->dateModification = null;
        }
    }

    /**
     * Sets the title of the post.
     * @param string|null $title The title of the post.
     */
    private function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Sets the chapo of the post.
     * @param string|null $chapo The chapo of the post.
     */
    private function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    /**
     * Sets the text of the post.
     * @param string|null $text The text of the post.
     */
    private function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Sets the image URL of the post.
     * @param string|null $img The image URL of the post.
     */
    private function setImg($img)
    {
        $this->img = $img;
    }
        
    /**
     * Sets the user ID associated with the post.
     * @param int|null $userId The user ID associated with the post.
     */
    private function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Sets the category ID associated with the post.
     * @param int|null $categoryId The category ID associated with the post.
     */
    private function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
}
