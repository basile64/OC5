<?php

namespace application\src\models\post;

use application\src\models\user\UserManager;
use application\src\models\category\CategoryManager;
use application\src\models\comment\MainCommentManager;

class Post {
    private const ID_COLUMN = 'id';
    private const DATE_CREATION_COLUMN = 'dateCreation';
    private const DATE_MODIFICATION_COLUMN = 'dateModification';
    private const TITLE_COLUMN = 'title';
    private const CHAPO_COLUMN = 'chapo';
    private const TEXT_COLUMN = 'text';
    private const IMG_COLUMN = 'img';
    private const USER_ID_COLUMN = 'userId';
    private const CATEGORY_ID_COLUMN = 'categoryId';

    private $id;
    private $dateCreation;
    private $dateModification;
    private $title;
    private $chapo;
    private $text;
    private $img;
    private $userId;
    private $categoryId;

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
    public function getId()
    {
        return $this->id;
    }

    public function getDateCreation($format = "Y-m-d")
    {
        return $this->dateCreation;
    }

    public function getDateModification($format = "Y-m-d")
    {
        return $this->dateModification;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getChapo()
    {
        return $this->chapo;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getImg()
    {
        return $this->img;
    }
        
    public function getUserId()
    {
        return $this->userId;
    } 
    
    public function getUser()
    {
        $userManager = new UserManager;
        $user = $userManager->get($this->userId);
        return $user;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function getMainComments()
    {
        $mainCommentManager = new MainCommentManager;
        $mainComments = $mainCommentManager->getAllApprovedByPostId($this->id);
        return $mainComments;
    }

    //Setters
    private function setId($id)
    {
        $this->id = $id;
    }

    private function setDateCreation($dateCreation)
    {
        if ($dateCreation != null){
            $this->dateCreation = new \DateTime($dateCreation);
        } else {
            $this->dateCreation = null;
        }
    }

    private function setDateModification($dateModification)
    {
        if ($dateModification != null){
            $this->dateModification = new \DateTime($dateModification);
        } else {
            $this->dateModification = null;
        }
    }

    private function setTitle($title)
    {
        $this->title = $title;
    }

    private function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    private function setText($text)
    {
        $this->text = $text;
    }

    private function setImg($img)
    {
        $this->img = $img;
    }
        
    private function setUserId($userId)
    {
        $this->userId = $userId;
    }

    private function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

}
