<?php

namespace application\src\controllers;

use application\src\models\contact\ContactManager;

class ContactController extends Controller
{

    /**
     * The manager instance for handling contact-related operations.
     *
     * @var ContactManager
     */
    private $contactManager;

    /**
     * Constructor method.
     * 
     * Initializes a new instance of the ContactController class.
     * If form is submitted, processes contact form; otherwise, shows contact page.
     */
    public function __construct()
    {
        parent::__construct(); 

        // Check if form is submitted
        $submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_STRING);
        if ($submit !== null) {
            $this->processContactForm();
            return;
        }

        // Show contact page if form is not submitted
        $this->showContactPage();
    }

    /**
     * Displays the contact page.
     */
    public function showContactPage()
    {
        // Retrieve form data from session, if available
        $formData = $this->sessionManager->getSessionVariable("contact_form_data") ?? [];
        $this->sessionManager->unsetSessionVariable("contactFormData");

        // Set view and render contact page
        $this->view = "contact/contactView";
        $this->render(['formData' => $formData]);
    }

    /**
     * Processes the submitted contact form.
     */
    public function processContactForm()
    {
        // Retrieve form data
        $firstName = filter_input(INPUT_POST, 'userFirstName', FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, 'userLastName', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
        $message = filter_input(INPUT_POST, 'userMessage', FILTER_SANITIZE_STRING);
        
        // Check if any value is null
        if ($firstName === null || $lastName === null || $email === null || $message === null) {
            // Handle case where any value is null
            $this->sessionManager->setSessionVariable("error_message", "Please fill in all the fields.");
            $this->sessionManager->setSessionVariable("contactFormData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header('Location: '.BASE_URL.'contact');
            return;
        }
    
        // Validate email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->sessionManager->setSessionVariable("error_message", "Invalid email format.");
            $this->sessionManager->setSessionVariable("contactFormData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header('Location: '.BASE_URL.'contact');
            return;
        }

        // Send email
        $this->contactManager = new ContactManager();
        if ($this->contactManager->sendEmail($firstName, $lastName, $email, $message) === true) {
            $this->sessionManager->setSessionVariable("success_message", "Your message has been sent.");
            header('Location: '.BASE_URL.'contact');
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error when sending the message.");
            $this->sessionManager->setSessionVariable("contactFormData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header('Location: '.BASE_URL.'contact');
            return;
        }
    }
}
