<?php

namespace application\src\models\post;

class Post {
    private $idPost;
    private $dateCreationPost;
    private $dateModificationPost;
    private $titlePost;
    private $chapoPost;
    private $textPost;
    private $categoryPost;
    private $authorPost;

    public function __construct($post){
        $this->setId($post['idPost'] ?? null);
        $this->setDateCreation($post['dateCreationPost'] ?? null);
        $this->setDateModification($post['dateModificationPost'] ?? null);
        $this->setTitle($post['titlePost'] ?? null);
        $this->setChapo($post['chapoPost'] ?? null);
        $this->setText($post['textPost'] ?? null);
        $this->setCategory($post['categoryPost'] ?? null);
        $this->setAuthor($post['authorPost'] ?? null);
    }

    //Getters
    public function getId(){
        return $this->idPost;
    }

    public function getDateCreation(){
        return $this->dateCreationPost;
    }

    public function getDateModification(){
        return $this->dateModificationPost;
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
    
    public function getCategory(){
        return $this->categoryPost;
    }
        
    public function getAuthor(){
        return $this->authorPost;
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
    
    public function setCategory($categoryPost){
        $this->categoryPost = $categoryPost;
    }
        
    public function setAuthor($authorPost){
        $this->authorPost = $authorPost;
    }

}