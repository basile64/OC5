<?php

namespace application\src\models\contact;

use \PHPMailer\PHPMailer\PHPMailer;

class ContactManager
{
    public function sendEmail($firstName, $lastName, $email, $message)
    {
        // Configuration de PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bspineaucros@gmail.com';
        $mail->Password = 'bdmggzgmtkmhvoys';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($email, $firstName . ' ' . $lastName);
        $mail->addAddress('basile.pineau@greta-cfa-aquitaine.academy'); // Adresse email de réception
        $mail->Subject = 'Nouveau message de ' . $firstName . ' ' . $lastName;

        $mail->addReplyTo($email, $firstName . ' ' . $lastName);

        $mail->isHTML(true);
        $mail->Body = $message;

        // Envoi de l'email
        if($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}
