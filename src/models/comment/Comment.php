<?php

namespace application\src\models\comment;

use application\src\models\user\UserManager;

class Comment {
    private $idComment;
    private $textComment;
    private $dateComment;
    private $statusComment;
    private $idPost;
    private $idUser;

    public function __construct($comment){
        $this->setIdComment($comment['idComment'] ?? null);
        $this->setText($comment['textComment'] ?? null);
        $this->setDate($comment['dateComment'] ?? null);
        $this->setStatus($comment['statusComment'] ?? null);
        $this->setIdPost($comment["idPost"] ?? null); 
        $this->setIdUser($comment["idUser"] ?? null); 
    }

    // Getters
    public function getIdComment(){
        return $this->idComment;
    }

    public function getText(){
        return $this->textComment;
    }

    public function getDate($format = "Y-m-d"){
        return ((new \DateTime($this->dateComment))->format($format));
    }

    public function getStatus(){
        return $this->statusComment;
    }

    public function getIdPost(){
        return $this->idPost;
    }

    public function getIdUser(){
        return $this->idUser;
    }

    public function getUser(){
        $userManager = new UserManager;
        $user = $userManager->getUser($this->idUser);
        return $user;
    }

    // Setters
    public function setIdComment($idComment){
        $this->idComment = $idComment;
    }

    public function setText($textComment){
        $this->textComment = $textComment;
    }

    public function setDate($dateComment){
        $this->dateComment = $dateComment;
    }

    public function setStatus($statusComment){
        $this->statusComment = $statusComment;
    }

    public function setIdPost($idPost){
        $this->idPost = $idPost;
    }

    public function setIdUser($idUser){
        $this->idUser = $idUser;
    }

}
