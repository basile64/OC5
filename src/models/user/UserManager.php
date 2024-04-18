<?php

namespace application\src\models\user;

use application\src\models\database\DbConnect;
use application\src\models\user\User;
use application\src\models\user\BasicUser;
use application\src\models\user\AdminUser;


class UserManager
{
    public static function getAll(){
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

    public static function getAllAdmin(){
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

    public function getAllBasic(){
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

    public function get($id){
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

    public function register(){
        return null;
    }

    public function create(){
        $formData = $_POST;

        $firstName = filter_var($formData["userFirstName"], FILTER_SANITIZE_STRING);
        $lastName = filter_var($formData["userLastName"], FILTER_SANITIZE_STRING);
        $email = filter_var($formData["userMail"], FILTER_VALIDATE_EMAIL);
        $password = $formData["password"];
        $confirmPassword = $formData["confirmPassword"];
    
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
            $_SESSION["error_message"] = "All fields are required.";
            $_SESSION["formData"] = $formData;
            header("Location: http://localhost/OC5/user/register");
            exit();
        }
    
        if ($this->checkIfEmailExists($email)) {
            $_SESSION["error_message"] = "An account with this email address already exists.";
            $_SESSION["formData"] = $formData;
            header("Location: http://localhost/OC5/user/register");
            exit();
        }
    
        if ($password != $confirmPassword){
            $_SESSION["error_message"] = "Passwords do not match.";
            $_SESSION["formData"] = $formData;
            header("Location: http://localhost/OC5/user/register");
            exit();
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
    
        if ($result !== false) {
            $_SESSION["success_message"] = "Your account is created.";
            unset($_SESSION['formData']);
            header("Location: http://localhost/OC5/user/login");
            exit();
        } else {
            $_SESSION["error_message"] = "Error creating your account.";
            $_SESSION["formData"] = $formData;
            header("Location: http://localhost/OC5/user/register");
            exit();
        }
    }
    

    public function checkIfEmailExists($mail){
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

    public function edit($id){
        return ($this->get($id));
    }

    public function update($id){
        $firstName = filter_var($_POST["userFirstName"], FILTER_SANITIZE_STRING);
        $lastName = filter_var($_POST["userLastName"], FILTER_SANITIZE_STRING);
        $mail = filter_var($_POST["userMail"], FILTER_VALIDATE_EMAIL);
        $role = filter_var($_POST["userRole"], FILTER_SANITIZE_STRING);
    
        // Vérifier que tous les champs sont remplis
        if (empty($firstName) || empty($lastName) || empty($mail) || empty($role)) {
            $_SESSION["error_message"] = "All fields are required.";
            header("Location: http://localhost/OC5/admin/usersManagement/edit/".$id);
            exit();
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
            $_SESSION["success_message"] = "User updated!";
            header("Location: http://localhost/OC5/admin/usersManagement");
            exit();
        } else {
            $_SESSION["error_message"] = "Error updating user.";
            header("Location: http://localhost/OC5/admin/usersManagement/edit/".$id);
            exit();
        }
    }
    
    

    public function delete($id){
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
            $_SESSION["success_message"] = "Utilisateur supprimé avec succès.";
            header("Location: http://localhost/OC5/admin/usersManagement");
            exit();
        } else {
            echo "Erreur lors de la suppression de l'utilisation.";
        }
    }

    public function login(){
        return null;
    }

    public function connect(){
        $post = $_POST;
        $userMail = filter_var($post["userMail"], FILTER_VALIDATE_EMAIL);
        $userPassword = $post["userPassword"];
    
        if (!$userMail) {
            $_SESSION["error_message"] = "Invalid email format.";
            $_SESSION["formData"] = $post;
            header("Location: http://localhost/OC5/user/login");
            exit();
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
            $_SESSION["success_message"] = "Connected !";
            $_SESSION["logged"] = true;
            $this->openSession($userData);
            unset($_SESSION['formData']);
            header("Location: http://localhost/OC5/");
            exit();
        } else {
            $_SESSION["error_message"] = "Incorrect email or password.";
            $_SESSION["formData"] = $post;
            header("Location: http://localhost/OC5/user/login");
            exit();
        }
    }
    

    public function openSession($userData){
        $user = new User($userData);
        $_SESSION["userId"] = $user->getId();
        $_SESSION["userFirstName"] = $user->getFirstName();
        $_SESSION["userLastName"] = $user->getLastName();
        $_SESSION["userMail"] = $user->getMail();
        $_SESSION["userAvatar"] = $user->getAvatar();
        $_SESSION["userDateRegistration"] = $user->getDateRegistration();
        $_SESSION["userRole"] = $user->getRole();
    }
    
    public function logout(){
        session_unset();
        header("Location: http://localhost/OC5/");
    }
    
    public function profile(){
        $user = $this->get($_SESSION["userId"]);
        return $user;
    }

    public function password(){
        return null;
    }

    public function changePassword(){
        $userId = $_SESSION["userId"];
        $user = $this->get($userId);
    
        $oldPassword = $_POST["oldPassword"];
        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];
    
        $oldPassword = filter_var($oldPassword, FILTER_SANITIZE_STRING);
        $newPassword = filter_var($newPassword, FILTER_SANITIZE_STRING);
        $confirmPassword = filter_var($confirmPassword, FILTER_SANITIZE_STRING);
    
        if (!password_verify($oldPassword, $user->getPassword())) {
            $_SESSION["error_message"] = "Incorrect old password.";
            header("Location: http://localhost/OC5/user/password");
            exit;
        }
    
        if ($newPassword !== $confirmPassword) {
            $_SESSION["error_message"] = "New password and confirmation do not match.";
            header("Location: http://localhost/OC5/user/password");
            exit;
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
    
        if ($result !== false) {
            $_SESSION["success_message"] = "Password updated successfully.";
            header("Location: http://localhost/OC5/user/profile");
            exit;
        } else {
            $_SESSION["error_message"] = "Error updating password.";
            header("Location: http://localhost/OC5/user/change-password");
            exit;
        }
    }
    
    

    public function save(){
        $user = $this->get($_SESSION["userId"]);
        $currentAvatar = $user->getAvatar();
    
        $firstName = filter_var($_POST["userFirstName"], FILTER_SANITIZE_STRING);
        $lastName = filter_var($_POST["userLastName"], FILTER_SANITIZE_STRING);
        $mail = filter_var($_POST["userMail"], FILTER_VALIDATE_EMAIL);
    
        if (empty($firstName) || empty($lastName) || empty($mail)) {
            $_SESSION["error_message"] = "All fields are required.";
            header("Location: http://localhost/OC5/user/profile");
            exit();
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
            ":id" => $_SESSION["userId"] 
        ];
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result !== false) {
            $_SESSION["success_message"] = "Profile updated!";
            $_SESSION["userAvatar"] = $avatarPath;
            $_SESSION["userFirstName"] = $firstName;
            $_SESSION["userLastName"] = $lastName;
            $_SESSION["userMail"] = $mail;
            header("Location: http://localhost/OC5/user/profile");
            exit();
        } else {
            $_SESSION["error_message"] = "Error saving your profile.";
            header("Location: http://localhost/OC5/user/profile");
            exit();
        }
    }
    

    public static function getNumberOfCommentsByUser($id){
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
