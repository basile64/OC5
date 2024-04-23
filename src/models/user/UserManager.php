<?php

namespace application\src\models\user;

use application\src\models\database\DbConnect;
use application\src\models\user\User;
use application\src\models\user\BasicUser;
use application\src\models\user\AdminUser;
use application\src\utils\SessionManager;

class UserManager
{

    public $sessionManager;

    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }

    public function getAll()
    {
        $query = "
            SELECT 
                *
            FROM
                user
            ORDER BY
                dateRegistration DESC
        ";

        $result = DbConnect::executeQuery($query);

        // Instanciation des commentaires en fonction du type
        $users = [];
        foreach ($result as $userData) {
            $user = new User($userData);
            $users[] = $user;
        }

        return $users;
    }

    public static function getAllAdmin()
    {
        $query = "
            SELECT 
                *
            FROM
                user
            WHERE
                role = 'admin'
            ORDER BY
                firstName ASC
        ";

        $result = DbConnect::executeQuery($query);

        // Instanciation des commentaires en fonction du type
        $users = [];
        foreach ($result as $userData) {
            $user = new User($userData);
            $users[] = $user;
        }

        return $users;
    }

    public function getAllBasic()
    {
        $query = "
            SELECT 
                *
            FROM
                user
            WHERE
                role = 'basic'
            ORDER BY
                firstName ASC
        ";

        $result = DbConnect::executeQuery($query);

        // Instanciation des commentaires en fonction du type
        $users = [];
        foreach ($result as $userData) {
            $user = new User($userData);
            $users[] = $user;
        }

        return $users;
    }

    public function get($id)
    {
        $query = "
            SELECT
                *
            FROM
                user
            WHERE 
                id = :id
        ";

        $params = [":id" => $id];
        $result = DbConnect::executeQuery($query, $params);

        $user = new User($result[0]);

        return $user;

    } 

    public function register()
    {
        return null;
    }

    public function create()
    {
        $firstName = filter_input(INPUT_POST, "userFirstName", FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, "userLastName", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "userMail", FILTER_VALIDATE_EMAIL);
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
    
        if ($firstName === null || $lastName === null || $email === null || $password === "" || $confirmPassword === "") {
            $this->sessionManager->setSessionVariable("error_message", "All fields are required.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".htmlspecialchars(BASE_URL)."user/register");
            return;
        }
    
        if ($this->checkIfEmailExists($email)) {
            $this->sessionManager->setSessionVariable("error_message", "An account with this email address already exists.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".htmlspecialchars(BASE_URL)."user/register");
            return;
        }
    
        if ($password != $confirmPassword){
            $this->sessionManager->setSessionVariable("error_message", "Passwords do not match.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".htmlspecialchars(BASE_URL)."user/register");
            return;
        }
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $query="
            INSERT 
            INTO
                user (firstName, lastName, mail, password, dateRegistration)
            VALUES
                (:firstName, :lastName, :mail, :password, NOW())
        ";
    
        $params = [
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":mail" => $email,
            ":password" => $hashedPassword,
        ];
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result === false) {
            $this->sessionManager->setSessionVariable("error_message", "Error creating your account.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".htmlspecialchars(BASE_URL)."user/register");
            return;
        }

        $this->sessionManager->setSessionVariable("success_message", "Your account is created.");
        $this->sessionManager->unsetSessionVariable("formData");
        header("Location: ".htmlspecialchars(BASE_URL)."user/login");
        return;
    }
    

    public function checkIfEmailExists($mail)
    {
        $query="
            SELECT
                mail
            FROM
                user
            WHERE
                mail = :mail
        ";

        $params = [
            ":mail" => $mail
        ];

        $result = DbConnect::executeQuery($query, $params);

        if (count($result) >= 1){
            return true;
        }

    }

    public function edit($id)
    {
        return ($this->get($id));
    }

    public function update($id)
    {
        $firstName = filter_input(INPUT_POST, "userFirstName", FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, "userLastName", FILTER_SANITIZE_STRING);
        $mail = filter_input(INPUT_POST, "userMail", FILTER_VALIDATE_EMAIL);
        $role = filter_input(INPUT_POST, "userRole", FILTER_SANITIZE_STRING);
    
        // Vérifier que tous les champs sont remplis
        if ($firstName === null || $lastName === null || $mail === null || $role === null) {
            $this->sessionManager->setSessionVariable("error_message", "All fields are required.");
            header("Location: ".htmlspecialchars(BASE_URL)."admin/usersManagement/edit/".$id);
            return;
        }
    
        $params = [
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":mail" => $mail,
            ":role" => $role,
            ":id" => $id
        ];
    
        $query = "
            UPDATE
                user
            SET
                firstName = :firstName,
                lastName = :lastName,
                mail = :mail,
                role = :role
            WHERE
                id = :id
        ";
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result !== false) {
            $this->sessionManager->setSessionVariable("success_message", "User updated !");
            header("Location: ".htmlspecialchars(BASE_URL)."admin/usersManagement");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error updating user.");
            header("Location: ".htmlspecialchars(BASE_URL)."admin/usersManagement/edit/".$id);
            return;
        }
    }
    
    

    public function delete($id)
    {
        $query="
            DELETE
            FROM
                user
            WHERE
                id = :id
        ";

        $params = [":id" => $id];

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $this->sessionManager->setSessionVariable("success_message", "User deleted !");
            header("Location: ".htmlspecialchars(BASE_URL)."admin/usersManagement");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error when deleting the user !");
            header("Location: ".htmlspecialchars(BASE_URL)."admin/usersManagement");
            return;
        }
    }

    public function login()
    {
        return null;
    }

    public function connect()
    {
        $userMail = filter_input(INPUT_POST, "userMail", FILTER_VALIDATE_EMAIL);
        $userPassword = $_POST["userPassword"];
    
        if ($userMail === null) {
            $this->sessionManager->setSessionVariable("error_message", "Invalid email format.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".htmlspecialchars(BASE_URL)."user/login");
            return;
        }
    
        $query="
            SELECT 
                id,
                firstName,
                lastName,
                mail,
                password,
                dateRegistration,
                role
            FROM
                user
            WHERE
                mail = :mail 
        ";
        $params = [":mail" => $userMail];
        $userData = DbConnect::executeQuery($query, $params)[0];
    
        if ($userData != NULL && password_verify($userPassword, $userData['password'])) {
            $this->sessionManager->setSessionVariable("success_message", "Connected !");
            $this->sessionManager->setSessionVariable("logged", true);

            $this->openSession($userData);
            $this->sessionManager->unsetSessionVariable("formData");
            header("Location: ".htmlspecialchars(BASE_URL));
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Incorrect email or password.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".htmlspecialchars(BASE_URL)."user/login");
            return;
        }
    }
    

    public function openSession($userData)
    {
        $user = new User($userData);
        $this->sessionManager->setSessionVariable("userId", $user->getId());
        $this->sessionManager->setSessionVariable("userFirstName", $user->getFirstName());
        $this->sessionManager->setSessionVariable("userLastName", $user->getLastName());
        $this->sessionManager->setSessionVariable("userMail", $user->getMail());
        $this->sessionManager->setSessionVariable("userAvatar", $user->getAvatar());
        $this->sessionManager->setSessionVariable("userDateRegistration", $user->getDateRegistration());
        $this->sessionManager->setSessionVariable("userRole", $user->getRole());
    }
    
    public function logout()
    {
        session_unset();
        header("Location: ".htmlspecialchars(BASE_URL));
    }
    
    public function profile()
    {
        $user = $this->get($this->sessionManager->getSessionVariable("userId"));
        return $user;
    }

    public function password()
    {
        return null;
    }

    public function changePassword()
    {
        $userId = $this->sessionManager->getSessionVariable("userId");
        $user = $this->get($userId);
    
        $oldPassword = $_POST["oldPassword"];
        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];
    
        $oldPassword = filter_var($oldPassword, FILTER_SANITIZE_STRING);
        $newPassword = filter_var($newPassword, FILTER_SANITIZE_STRING);
        $confirmPassword = filter_var($confirmPassword, FILTER_SANITIZE_STRING);
    
        if (!password_verify($oldPassword, $user->getPassword())) {
            $this->sessionManager->setSessionVariable("error_message", "Incorrect old password.");
            header("Location: ".htmlspecialchars(BASE_URL)."user/password");
            return;
        }
    
        if ($newPassword !== $confirmPassword) {
            $this->sessionManager->setSessionVariable("error_message", "New password and confirmation do not match.");
            header("Location: ".htmlspecialchars(BASE_URL)."user/password");
            return;
        }
    
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        $query = "
            UPDATE
                user
            SET
                password = :password
            WHERE  
                id = :id
        ";
    
        $params = [
            ":password" => $hashedNewPassword,
            ":id" => $userId
        ];
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result === false) {
            $this->sessionManager->setSessionVariable("error_message", "Error updating password.");
            header("Location: ".htmlspecialchars(BASE_URL)."user/change-password");
            return;
        }

        $this->sessionManager->setSessionVariable("success_message", "Password successfully updated.");
        header("Location: ".htmlspecialchars(BASE_URL)."user/profile");
        return;
        
    }
    
    

    public function save()
    {
        $user = $this->get($this->sessionManager->getSessionVariable("userId"));
        $currentAvatar = $user->getAvatar();
    
        $firstName = filter_input(INPUT_POST, "userFirstName", FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, "userLastName", FILTER_SANITIZE_STRING);
        $mail = filter_input(INPUT_POST, "userMail", FILTER_VALIDATE_EMAIL);        
    
        if ($firstName === null || $lastName === null || $mail === null) {
            $this->sessionManager->setSessionVariable("error_message", "All fields are required.");
            header("Location: ".htmlspecialchars(BASE_URL)."user/profile");
            return;
        }
    
        if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] === UPLOAD_ERR_OK) {
            $avatarName = filter_var($_FILES["avatar"]["name"], FILTER_SANITIZE_STRING);
            $avatarPath = "../public/avatar/" . basename($avatarName);
            move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatarPath);
        } else {
            $avatarPath = $currentAvatar;
        }
    
        $query = "
            UPDATE
                user
            SET
                avatar = :avatar,
                firstName = :firstName,
                lastName = :lastName,
                mail = :mail
            WHERE
                id = :id
        ";
    
        $params = [
            ":avatar" => $avatarPath,  
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":mail" => $mail,
            ":id" => $this->sessionManager->getSessionVariable("userId")
        ];
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result !== false) {
            $this->sessionManager->setSessionVariable("success_message", "Profile updated !");
            $this->sessionManager->setSessionVariable("userAvatar", $avatarPath);
            $this->sessionManager->setSessionVariable("userFirstName", $firstName);
            $this->sessionManager->setSessionVariable("userLastName", $lastName);
            $this->sessionManager->setSessionVariable("userMail", $mail);            
            header("Location: ".htmlspecialchars(BASE_URL)."user/profile");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error saving your profile.");
            header("Location: ".htmlspecialchars(BASE_URL)."user/profile");
            return;
        }
    }
    

    public static function getNumberOfCommentsByUser($id)
    {
        $query = "
        SELECT 
            COUNT(*) as commentCount
        FROM
            comment
        WHERE
            userId = :id
        ";

        $params = [":id" => $id];
        $result = DbConnect::executeQuery($query, $params);

        // Retourner le nombre de commentaires de l'utilisateur
        return $result[0]['commentCount'];
    }
}
