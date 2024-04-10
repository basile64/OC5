<?php

namespace application\src\models\contact;

class Contact {
    private $firstName;
    private $lastName;
    private $email;
    private $message;

    public function __construct($contact){
        $this->setFirstName($contact['firstName'] ?? null);
        $this->setLastName($contact['lastName'] ?? null);
        $this->setEmail($contact['email'] ?? null);
        $this->setMessage($contact['message'] ?? null);
    }

    // Getters
    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getMessage(){
        return $this->message;
    }

    // Setters
    public function setFirstName($firstName){
        $this->firstName = $firstName;
    }

    public function setLastName($lastName){
        $this->lastName = $lastName;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setMessage($message){
        $this->message = $message;
    }
}
