<?php

namespace application\src\models\contact;

class Contact {
    private const FIRST_NAME_COLUMN = 'firstName';
    private const LAST_NAME_COLUMN = 'lastName';
    private const EMAIL_COLUMN = 'email';
    private const MESSAGE_COLUMN = 'message';

    private $firstName;
    private $lastName;
    private $email;
    private $message;

    public function __construct($contact){
        $this->setFirstName($contact[self::FIRST_NAME_COLUMN] ?? null);
        $this->setLastName($contact[self::LAST_NAME_COLUMN] ?? null);
        $this->setEmail($contact[self::EMAIL_COLUMN] ?? null);
        $this->setMessage($contact[self::MESSAGE_COLUMN] ?? null);
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
    private function setFirstName($firstName){
        $this->firstName = $firstName;
    }

    private function setLastName($lastName){
        $this->lastName = $lastName;
    }

    private function setEmail($email){
        $this->email = $email;
    }

    private function setMessage($message){
        $this->message = $message;
    }
}
