<?php

namespace application\src\controllers;

use application\src\models\contact\ContactManager;

class ContactController extends Controller
{

    private $contactManager;

    public function __construct()
    {
        parent::__construct(); 
        if (isset($_POST['submit']) == true){
            $this->processContactForm();
            return;
        }
        $this->showContactPage();
    }

    public function showContactPage()
    {
        $formData = $this->sessionManager->getSessionVariable("contact_form_data") ?? [];

        $this->sessionManager->unsetSessionVariable("contactFormData");

        $this->view = "contact/contactView";
        $this->render(['formData' => $formData]);
    }

    public function processContactForm()
    {
        $firstName = filter_var($_POST['userFirstName'] ?? '', FILTER_SANITIZE_STRING);
        $lastName = filter_var($_POST['userLastName'] ?? '', FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['userEmail'] ?? '', FILTER_SANITIZE_EMAIL);
        $message = filter_var($_POST['userMessage'] ?? '', FILTER_SANITIZE_STRING);
    
        if (empty($firstName)  == true || empty($lastName) == true || empty($email) == true || empty($message) == true) {
            $this->sessionManager->setSessionVariable("error_message", "Please fill in all the fields.");
            $this->sessionManager->setSessionVariable("contactFormData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header('Location: '.BASE_URL.'contact');
            return;
        }
    
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $this->sessionManager->setSessionVariable("error_message", "Invalid email format.");
            $this->sessionManager->setSessionVariable("contactFormData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header('Location: '.BASE_URL.'contact');
            return;
        }

        $this->contactManager = new ContactManager();
        if ($this->contactManager->sendEmail($firstName, $lastName, $email, $message) == true) {
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
