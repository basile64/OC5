<?php

namespace application\src\models\comment;

class Comment {
    private $idComment;
    private $dateComment;
    private $textComment;
    private $statusComment;
    private $authorComment;

    public function __construct($comment){
        $this->setId($comment['idComment'] ?? null);
        $this->setDate($comment['dateComment'] ?? null);
        $this->setText($comment['textComment'] ?? null);
        $this->setStatus($comment['statusComment'] ?? null);
        $this->setAuthor($comment['authorComment'] ?? null);
    }

    // Getters
    public function getId(){
        return $this->idComment;
    }

    public function getDate(){
        return $this->dateComment;
    }

    public function getText(){
        return $this->textComment;
    }

    public function getStatus(){
        return $this->statusComment;
    }

    public function getAuthor(){
        return $this->authorComment;
    }


    // Setters
    public function setId($idComment){
        $this->idComment = $idComment;
    }

    public function setDate($dateComment){
        $this->dateComment = $dateComment;
    }

    public function setText($textComment){
        $this->textComment = $textComment;
    }

    public function setStatus($statusComment){
        $this->statusComment = $statusComment;
    }

    public function setAuthor($authorComment){
        $this->authorComment = $authorComment;
    }

}
