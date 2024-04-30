<?php

namespace application\src\models\contact;

use \PHPMailer\PHPMailer\PHPMailer;

class ContactManager
{
    
    /**
     * Sends an email with the provided details.
     *
     * @param string $firstName The first name of the sender.
     * @param string $lastName The last name of the sender.
     * @param string $email The email address of the sender.
     * @param string $message The message content.
     * @return bool True if the email was sent successfully, false otherwise.
     */
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

        /**
     * Sends an email with the provided details.
     *
     * @param string $firstName The first name of the sender.
     * @param string $email The email address of the sender.
     * @param string $token The confirmation token.
     * @return bool True if the email was sent successfully, false otherwise.
     */
    public function sendEmailConfirmation($firstName, $email, $token)
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

        $mail->setFrom('bspineaucros@gmail.com', 'OC5');
        $mail->addAddress($email);
        $mail->Subject = 'Email Confirmation';

        // Lien de confirmation
        $confirmationLink = BASE_URL . 'user/confirmEmail/' . $token;

        // Contenu de l'email
        $message = '
            <html>
            <body>
                <h2>Email confirmation</h2>
                <p>Hello ' . $firstName . ',</p>
                <p>Please click the following link to confirm your email address:</p>
                <p><a href="' . $confirmationLink . '">Confirm email</a></p>
            </body>
            </html>
        ';

        $mail->isHTML(true);
        $mail->Body = $message;

        // Envoi de l'email
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}
