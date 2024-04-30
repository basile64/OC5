<?php

namespace application\src\models\contact;

/**
 * Represents a contact entity.
 */
class Contact
{
    /**
     * The column name for the first name in the contact data.
     */
    private const FIRST_NAME_COLUMN = 'firstName';

    /**
     * The column name for the last name in the contact data.
     */
    private const LAST_NAME_COLUMN = 'lastName';

    /**
     * The column name for the email in the contact data.
     */
    private const EMAIL_COLUMN = 'email';

    /**
     * The column name for the message in the contact data.
     */
    private const MESSAGE_COLUMN = 'message';

    /**
     * The first name of the contact.
     *
     * @var string|null
     */
    private $firstName;

    /**
     * The last name of the contact.
     *
     * @var string|null
     */
    private $lastName;

    /**
     * The email address of the contact.
     *
     * @var string|null
     */
    private $email;

    /**
     * The message from the contact.
     *
     * @var string|null
     */
    private $message;

    /**
     * Constructor method for Contact class.
     *
     * Initializes a new instance of Contact class with the provided contact data.
     *
     * @param array $contact An array containing contact data.
     * @return void
     */
    public function __construct($contact)
    {
        $this->setFirstName($contact[self::FIRST_NAME_COLUMN] ?? null);
        $this->setLastName($contact[self::LAST_NAME_COLUMN] ?? null);
        $this->setEmail($contact[self::EMAIL_COLUMN] ?? null);
        $this->setMessage($contact[self::MESSAGE_COLUMN] ?? null);
    }

    /**
     * Retrieves the first name of the contact.
     *
     * @return string|null The first name of the contact.
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Retrieves the last name of the contact.
     *
     * @return string|null The last name of the contact.
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Retrieves the email address of the contact.
     *
     * @return string|null The email address of the contact.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Retrieves the message from the contact.
     *
     * @return string|null The message from the contact.
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the first name of the contact.
     *
     * @param string|null $firstName The first name of the contact.
     * @return void
     */
    private function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Sets the last name of the contact.
     *
     * @param string|null $lastName The last name of the contact.
     * @return void
     */
    private function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Sets the email address of the contact.
     *
     * @param string|null $email The email address of the contact.
     * @return void
     */
    private function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Sets the message from the contact.
     *
     * @param string|null $message The message from the contact.
     * @return void
     */
    private function setMessage($message)
    {
        $this->message = $message;
    }
}
