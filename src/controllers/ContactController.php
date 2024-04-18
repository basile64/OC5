<?php

namespace application\src\controllers;

use application\src\models\contact\ContactManager;

class ContactController extends Controller
{
    private $contactManager;

    public function __construct(){
        if(isset($_POST['submit'])) {
            $this->processContactForm();
        } else {
            $this->showContactPage();
        }
    }

    public function showContactPage(){
        $formData = $_SESSION['contact_form_data'] ?? [];

        unset($_SESSION['contactFormData']);

        $this->view = "contact/contactView";
        $this->render(['formData' => $formData]);
    }

    public function processContactForm() {
        $formData = $_POST;
        
        $firstName = filter_var($formData['userFirstName'] ?? '', FILTER_SANITIZE_STRING);
        $lastName = filter_var($formData['userLastName'] ?? '', FILTER_SANITIZE_STRING);
        $email = filter_var($formData['userEmail'] ?? '', FILTER_SANITIZE_EMAIL);
        $message = filter_var($formData['userMessage'] ?? '', FILTER_SANITIZE_STRING);
    
        if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
            $_SESSION["error_message"] = "Please fill in all the fields.";
            $_SESSION['contactFormData'] = $formData;
            header('Location: http://localhost/OC5/contact');
            exit();
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error_message"] = "Invalid email format.";
            $_SESSION['contactFormData'] = $formData;
            header('Location: http://localhost/OC5/contact');
            exit();
        }
    
        $this->contactManager = new ContactManager();
        if($this->contactManager->sendEmail($firstName, $lastName, $email, $message)) {
            $_SESSION["success_message"] = "Your message has been sent.";
            header('Location: http://localhost/OC5/contact');
            exit();
        } else {
            $_SESSION["error_message"] = "Error when sending the message.";
            $_SESSION['contactFormData'] = $formData;
            header('Location: http://localhost/OC5/contact');
            exit();
        }
    }
    
}
