<?php

namespace application\src\controllers;

use application\src\models\contact\ContactManager;

class ContactController extends Controller{
    private $contactManager;

    public function __construct($explodedUrl){
        if(isset($_POST['submit'])) {
            $this->processContactForm();
        } else {
            $this->showContactPage();
        }
    }

    public function showContactPage(){
        $this->view = "contact/contactView";
        $this->render();
    }

    public function processContactForm() {
        $formData = array_map('htmlspecialchars', $_POST);
    
        $firstName = $formData['firstNameUser'] ?? '';
        $lastName = $formData['lastNameUser'] ?? '';
        $email = $formData['emailUser'] ?? '';
        $message = $formData['messageUser'] ?? '';
    
        $this->contactManager = new ContactManager();
        if($this->contactManager->sendEmail($firstName, $lastName, $email, $message)) {
            $_SESSION["success_message"] = "Your message has been sent.";
            header('Location: http://localhost/OC5/contact');
        } else {
            $_SESSION["error_message"] = "Error when sending the message.";
            header('Location: http://localhost/OC5/contact');
        }
    }
}
