<?php

namespace application\src\models\user;

class User {
    private const ID_COLUMN = 'id';
    private const FIRST_NAME_COLUMN = 'firstName';
    private const LAST_NAME_COLUMN = 'lastName';
    private const MAIL_COLUMN = 'mail';
    private const AVATAR_COLUMN = 'avatar';
    private const PASSWORD_COLUMN = 'password';
    private const DATE_REGISTRATION_COLUMN = 'dateRegistration';
    private const ROLE_COLUMN = 'role';

    private $id;
    private $firstName;
    private $lastName;
    private $mail;
    private $avatar;
    private $password;
    private $dateRegistration;
    private $role;

    public function __construct($user)
    {
        $this->setId($user[self::ID_COLUMN] ?? null);
        $this->setFirstName($user[self::FIRST_NAME_COLUMN] ?? null);
        $this->setLastName($user[self::LAST_NAME_COLUMN] ?? null);
        $this->setMail($user[self::MAIL_COLUMN] ?? null);
        $this->setAvatar($user[self::AVATAR_COLUMN] ?? null);
        $this->setPassword($user[self::PASSWORD_COLUMN] ?? null);
        $this->setDateRegistration($user[self::DATE_REGISTRATION_COLUMN] ?? null);
        $this->setRole($user[self::ROLE_COLUMN] ?? null);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getPassword()
    {
        return $this->password;
    }
    
    public function getDateRegistration($format = "Y-m-d")
    {
        return ((new \DateTime($this->dateRegistration))->format($format));
    }

    public function getRole()
    {
        return $this->role;
    }

    private function setId($id)
    {
        $this->id = $id;
    }

    private function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    private function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    private function setMail($mail)
    {
        $this->mail = $mail;
    }

    private function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    private function setPassword($password)
    {
        $this->password = $password;
    }

    private function setDateRegistration($dateRegistration)
    {
        $this->dateRegistration = $dateRegistration;
    }

    private function setRole($role)
    {
        $this->role = $role;
    }

}
