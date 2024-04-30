<?php

namespace application\src\models\user;

/**
 * Represents a user entity.
 */
class User
{
    
    /**
     * The column name for the user ID in the database.
     *
     * @var string
     */
    private const ID_COLUMN = 'id';
    
    /**
     * The column name for the user's first name in the database.
     *
     * @var string
     */
    private const FIRST_NAME_COLUMN = 'firstName';
    
    /**
     * The column name for the user's last name in the database.
     *
     * @var string
     */
    private const LAST_NAME_COLUMN = 'lastName';
    
    /**
     * The column name for the user's email in the database.
     *
     * @var string
     */
    private const MAIL_COLUMN = 'mail';
    
    /**
     * The column name for the user's avatar in the database.
     *
     * @var string
     */
    private const AVATAR_COLUMN = 'avatar';
    
    /**
     * The column name for the user's password in the database.
     *
     * @var string
     */
    private const PASSWORD_COLUMN = 'password';
    
    /**
     * The column name for the user's registration date in the database.
     *
     * @var string
     */
    private const DATE_REGISTRATION_COLUMN = 'dateRegistration';
    
    /**
     * The column name for the user's role in the database.
     *
     * @var string
     */
    private const ROLE_COLUMN = 'role';

        /**
     * The column name for the user's email confirmed.
     *
     * @var string
     */
    private const EMAIL_CONFIRMED_COLUMN = 'emailConfirmed';

        /**
     * The column name for the user's token.
     *
     * @var string
     */
    private const TOKEN_COLUMN = 'token';

    /**
     * The user's ID.
     *
     * @var int|null
     */
    private $id;

    /**
     * The user's first name.
     *
     * @var string|null
     */
    private $firstName;

    /**
     * The user's last name.
     *
     * @var string|null
     */
    private $lastName;

    /**
     * The user's email.
     *
     * @var string|null
     */
    private $mail;

    /**
     * The user's avatar.
     *
     * @var string|null
     */
    private $avatar;

    /**
     * The user's password.
     *
     * @var string|null
     */
    private $password;

    /**
     * The user's registration date.
     *
     * @var string|null
     */
    private $dateRegistration;

    /**
     * The user's role.
     *
     * @var string|null
     */
    private $role;

    /**
     * The user's confirmed mail.
     *
     * @var int|null
     */
    private $emailConfirmed;

    /**
     * The user's token.
     *
     * @var string|null
     */
    private $token;

    /**
     * User constructor.
     *
     * @param array $user The user data array.
     */
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
        $this->setEmailConfirmed($user[self::EMAIL_CONFIRMED_COLUMN] ?? null);
        $this->setToken($user[self::TOKEN_COLUMN] ?? null);
    }

    /**
     * Get the user's ID.
     *
     * @return int|null The user's ID.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the user's first name.
     *
     * @return string|null The user's first name.
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get the user's last name.
     *
     * @return string|null The user's last name.
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get the user's email.
     *
     * @return string|null The user's email.
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Get the user's avatar.
     *
     * @return string|null The user's avatar.
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Get the user's password.
     *
     * @return string|null The user's password.
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Get the user's registration date.
     *
     * @param string $format The date format (default is "Y-m-d").
     * @return string|null The user's registration date.
     */
    public function getDateRegistration($format = "Y-m-d")
    {
        return ((new \DateTime($this->dateRegistration))->format($format));
    }

    /**
     * Get the user's role.
     *
     * @return string|null The user's role.
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the user's email confirmed.
     *
     * @return int|null The user's role.
     */
    public function getEmailConfirmed()
    {
        return $this->emailConfirmed;
    }

    /**
     * Get the user's token.
     *
     * @return string|null The user's role.
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the user's ID.
     *
     * @param int|null $id The user's ID.
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set the user's first name.
     *
     * @param string|null $firstName The user's first name.
     */
    private function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Set the user's last name.
     *
     * @param string|null $lastName The user's last name.
     */
    private function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Set the user's email.
     *
     * @param string|null $mail The user's email.
     */
    private function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Set the user's avatar.
     *
     * @param string|null $avatar The user's avatar.
     */
    private function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * Set the user's password.
     *
     * @param string|null $password The user's password.
     */
    private function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Set the user's registration date.
     *
     * @param string|null $dateRegistration The user's registration date.
     */
    private function setDateRegistration($dateRegistration)
    {
        $this->dateRegistration = $dateRegistration;
    }

    /**
     * Set the user's role.
     *
     * @param string|null $role The user's role.
     */
    private function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Set the user's emailConfirmed.
     *
     * @param int|null $role The user's role.
     */
    private function setEmailConfirmed($emailConfirmed)
    {
        $this->emailConfirmed = $emailConfirmed;
    }

    /**
     * Set the user's token.
     *
     * @param string|null $role The user's role.
     */
    private function setToken($token)
    {
        $this->token = $token;
    }

}
