<?php

namespace application\src\models\post;

use application\src\models\user\UserManager;
use application\src\models\category\CategoryManager;
use application\src\models\comment\MainCommentManager;

class Post {
    private $idPost;
    private $dateCreationPost;
    private $dateModificationPost;
    private $titlePost;
    private $chapoPost;
    private $textPost;
    private $imgPost;
    private $idUser;
    private $idCategory;

    public function __construct($post){
        $this->setId($post['idPost'] ?? null);
        $this->setDateCreation($post['dateCreationPost'] ?? null);
        $this->setDateModification($post['dateModificationPost'] ?? null);
        $this->setTitle($post['titlePost'] ?? null);
        $this->setChapo($post['chapoPost'] ?? null);
        $this->setText($post['textPost'] ?? null);
        $this->setImg($post['imgPost'] ?? null);
        $this->setIdCategory($post['idCategory'] ?? null);
        $this->setIdUser($post['idUser'] ?? null);
    }

    //Getters
    public function getId(){
        return $this->idPost;
    }

    public function getDateCreation($format = "Y-m-d"){
        return ((new \DateTime($this->dateCreationPost))->format($format));
    }

    public function getDateModification($format = "Y-m-d"){
        $dateModification = $this->dateModificationPost;
    
        if ($dateModification != null) {
            $dateTime = new \DateTime($dateModification);
            return $dateTime->format($format);
        } else {
            return "0000-00-00";
        }
    }

    public function getTitle(){
        return $this->titlePost;
    }

    public function getChapo(){
        return $this->chapoPost;
    }

    public function getText(){
        return $this->textPost;
    }

    public function getImg(){
        return $this->imgPost;
    }
        
    public function getIdUser(){
        return $this->idUser;
    } 
    
    public function getUser(){
        $userManager = new UserManager;
        $user = $userManager->getUser($this->idUser);
        return $user;
    }

    public function getIdCategory(){
        return $this->idCategory;
    }

    public function getMainComments(){
        $mainCommentManager = new MainCommentManager;
        $mainComments = $mainCommentManager->getAllApprovedByIdPost($this->idPost);
        return $mainComments;
    }

    //Setters
    public function setId($idPost){
        $this->idPost = $idPost;
    }

    public function setDateCreation($dateCreationPost){
        $this->dateCreationPost = $dateCreationPost;
    }

    public function setDateModification($dateModificationPost){
        $this->dateModificationPost = $dateModificationPost;
    }

    public function setTitle($titlePost){
        $this->titlePost = $titlePost;
    }

    public function setChapo($chapoPost){
        $this->chapoPost = $chapoPost;
    }

    public function setText($textPost){
        $this->textPost = $textPost;
    }

    public function setImg($imgPost){
        $this->imgPost = $imgPost;
    }
        
    public function setIdUser($idUser){
        $this->idUser = $idUser;
    }

    public function setIdCategory($idCategory){
        $this->idCategory = $idCategory;
    }

}