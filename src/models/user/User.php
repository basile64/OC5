<?php

namespace application\src\models\user;

class User {
    private $idUser;
    private $firstNameUser;
    private $lastNameUser;
    private $mailUser;
    private $passwordUser;
    private $dateRegistrationUser;
    private $roleUser;

    public function __construct($user){
        $this->setIdUser($user['idUser'] ?? null);
        $this->setFirstName($user['firstNameUser'] ?? null);
        $this->setLastName($user['lastNameUser'] ?? null);
        $this->setMail($user["mailUser"] ?? null);
        $this->setPassword($user['passwordUser'] ?? null);
        $this->setDateRegistration($user['dateRegistrationUser'] ?? null);
        $this->setRole($user['roleUser'] ?? null);
    }

    public function getIdUser(){
        return $this->idUser;
    }

    public function getFirstName(){
        return $this->firstNameUser;
    }

    public function getLastName(){
        return $this->lastNameUser;
    }

    public function getMail(){
        return $this->mailUser;
    }

    public function getPassword(){
        return $this->passwordUser;
    }
    
    public function getDateRegistration($format = "Y-m-d"){
        return ((new \DateTime($this->dateRegistrationUser))->format($format));
    }

    public function getRole(){
        return $this->roleUser;
    }

    public function setIdUser($idUser){
        $this->idUser = $idUser;
    }

    public function setFirstName($firstNameUser){
        $this->firstNameUser = $firstNameUser;
    }

    public function setLastName($lastNameUser){
        $this->lastNameUser = $lastNameUser;
    }

    public function setMail($mailUser){
        $this->mailUser = $mailUser;
    }

    public function setPassword($passwordUser){
        $this->passwordUser = $passwordUser;
    }

    public function setDateRegistration($dateRegistrationUser){
        $this->dateRegistrationUser = $dateRegistrationUser;
    }

    public function setRole($roleUser){
        $this->roleUser = $roleUser;
    }

}