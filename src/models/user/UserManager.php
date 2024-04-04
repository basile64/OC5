<?php

namespace application\src\models\user;

use application\src\models\database\DbConnect;
use application\src\models\user\User;
use application\src\models\user\BasicUser;
use application\src\models\user\AdminUser;


class UserManager {

    public static function getAll(){
        $query = "
            SELECT 
                *
            FROM
                user
            ORDER BY
                dateRegistrationUser DESC
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
                roleUser = 'admin'
            ORDER BY
                firstNameUser ASC
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
                roleUser = 'basic'
            ORDER BY
                firstNameUser ASC
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

    public function getUser($idUser){
        $query = "
            SELECT
                *
            FROM
                user
            WHERE 
                idUser = :idUser
        ";

        $params = [":idUser" => $idUser];
        $result = DbConnect::executeQuery($query, $params);

        $user = new User($result[0]);

        return $user;

    }

    public function registerUser(){
        //Pas besoin de retourner une variable, la vue nous suffit
        return null;
    }

    public function createUser(){
        $newUser = array_map("htmlspecialchars", $_POST);

        if ($this->checkIfEmailExists($newUser["mailUser"])) {
            $_SESSION["error_message"] = "An account with this email address already exists.";
            header("Location: http://localhost/OC5/user/register");
            exit();
        }

        if ($newUser["passwordUser"] == $newUser["confirmPasswordUser"]){
            $hashedPassword = password_hash($newUser["passwordUser"], PASSWORD_DEFAULT);

            $query="
                INSERT 
                INTO
                    user (firstNameUser, lastNameUser, mailUser, passwordUser, dateRegistrationUser)
                VALUES
                    (:firstNameUser, :lastNameUser, :mailUser, :passwordUser, NOW())
            ";

            $params = [
                ":firstNameUser" => $newUser["firstNameUser"],
                ":lastNameUser" => $newUser["lastNameUser"],
                ":mailUser" => $newUser["mailUser"],
                ":passwordUser" => $hashedPassword,
            ];
            //Insertion table User
            $result = DbConnect::executeQuery($query, $params);

            if ($result !== false) {
                $_SESSION["success_message"] = "Your account is created.";
                header("Location: http://localhost/OC5/user/login");
            }else{
                $_SESSION["error_message"] = "Error creating your account.";
                header("Location: http://localhost/OC5/user/register");
            }
        } else {
            $_SESSION["error_message"] = "Password do not match.";
            header("Location: http://localhost/OC5/user/register");
        }
    }

    public function checkIfEmailExists($mail){
        $query="
            SELECT
                mailUser
            FROM
                user
            WHERE
                mailUser = :mailUser
        ";

        $params = [
            ":mailUser" => $mail
        ];

        $result = DbConnect::executeQuery($query, $params);

        if (count($result) >= 1){
            return true;
        }

    }

    public function editUser($idUser){
        return ($this->getUser($idUser));
    }

    public function updateUser($idUser){
        if(isset($_POST["firstNameUser"], $_POST["lastNameUser"], $_POST["mailUser"], $_POST["roleUser"])) {
    
            $params = [
                ":firstNameUser" => $_POST["firstNameUser"],
                ":lastNameUser" => $_POST["lastNameUser"],
                ":mailUser" => $_POST["mailUser"],
                ":roleUser" => $_POST["roleUser"],
                ":idUser" => $idUser
            ];
    
            $query = "
                UPDATE
                    user
                SET
                    firstNameUser = :firstNameUser,
                    lastNameUser = :lastNameUser,
                    mailUser = :mailUser,
                    roleUser = :roleUser
            ";
    
            $query .= "
                WHERE
                    idUser = :idUser
            ";
    
            $result = DbConnect::executeQuery($query, $params);
    
            if ($result !== false) {
                $_SESSION["success_message"] = "User updated!";
                header("Location: http://localhost/OC5/admin/usersManagement");
                exit();
            } else {
                echo "Erreur lors de la modification de l'utilisateur.";
            }
        } else {
            echo "Tous les champs requis ne sont pas remplis.";
        }
    }

    public function deleteUser($idUser){
        $query="
            DELETE
            FROM
                user
            WHERE
                idUser = :idUser
        ";

        $params = [":idUser" => $idUser];

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $_SESSION["success_message"] = "Utilisateur supprimé avec succès.";
            header("Location: http://localhost/OC5/admin/usersManagement");
            exit();
        } else {
            echo "Erreur lors de la suppression de l'utilisation.";
        }
    }

    public function loginUser(){
        return null;
    }

    public function connectUser(){
        $post = array_map("htmlspecialchars", $_POST);
        $mailUser = $post["mailUser"];
        $passwordUser = $post["passwordUser"];
        $query="
            SELECT 
                idUser,
                firstNameUser,
                lastNameUser,
                mailUser,
                passwordUser,
                dateRegistrationUser,
                roleUser
            FROM
                user
            WHERE
                mailUser = :mailUser 
        ";
        $params = [":mailUser" => $mailUser];
        $userData = DbConnect::executeQuery($query, $params)[0];

        if ($userData != NULL && password_verify($passwordUser, $userData['passwordUser'])) {
            $_SESSION["success_message"] = "Connected !";
            $_SESSION["logged"] = true;
            $this->openSession($userData);
            header("Location: http://localhost/OC5/");
        } else {
            $_SESSION["error_message"] = "Incorrect email or password.";
            header("Location: http://localhost/OC5/user/login");
        }
    }

    public function openSession($userData){
        $user = new User($userData);
        $_SESSION["idUser"] = $user->getId();
        $_SESSION["firstNameUser"] = $user->getFirstName();
        $_SESSION["lastNameUser"] = $user->getLastName();
        $_SESSION["mailUser"] = $user->getMail();
        $_SESSION["avatarUser"] = $user->getAvatar();
        $_SESSION["dateRegistrationUser"] = $user->getDateRegistration();
        $_SESSION["roleUser"] = $user->getRole();
    }
    
    public function logoutUser(){
        session_unset();
        header("Location: http://localhost/OC5/");
    }
    
    public function profileUser(){
        $user = $this->getUser($_SESSION["idUser"]);
        return $user;
    }

    public function passwordUser(){
        return null;
    }

    public function changePasswordUser(){
        $userId = $_SESSION["idUser"];
        $user = $this->getUser($userId);
    
        $oldPassword = $_POST["oldPassword"];
        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];
    
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
                passwordUser = :passwordUser
            WHERE  
                idUser = :idUser
        ";
    
        $params = [
            ":passwordUser" => $hashedNewPassword,
            ":idUser" => $userId
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
    

    public function saveUser(){
        $user = $this->getUser($_SESSION["idUser"]);
        $currentAvatar = $user->getAvatar();
        $filteredUser = array_map('htmlspecialchars', $_POST);

        if (isset($_FILES["avatarUser"]) && $_FILES["avatarUser"]["error"] === UPLOAD_ERR_OK) {
            $filteredAvatar = array_map('htmlspecialchars', $_FILES['avatarUser']);
            $avatarPath = basename($filteredAvatar["name"]);
            move_uploaded_file($filteredAvatar["tmp_name"], "../public/avatar/" . $avatarPath);
        } else {
            $avatarPath = $currentAvatar;
        }
    
        $query ="
            UPDATE
                user
            SET
                avatarUser = :avatarUser,
                firstNameUser = :firstNameUser,
                lastNameUser = :lastNameUser,
                mailUser = :mailUser
            WHERE
                idUser = :idUser
        ";
    
        // Paramètres de la requête
        $params = [
            ":avatarUser" => $avatarPath,  
            ":firstNameUser" => $filteredUser["firstNameUser"],
            ":lastNameUser" => $filteredUser["lastNameUser"],
            ":mailUser" => $filteredUser["mailUser"],
            ":idUser" => $_SESSION["idUser"] 
        ];



        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $_SESSION["success_message"] = "Profile updated !";
            $_SESSION["avatarUser"] = $avatarPath;
            $_SESSION["firstNameUser"] = $filteredUser["firstNameUser"];
            $_SESSION["lastNameUser"] = $filteredUser["lastNameUser"];
            $_SESSION["mailUser"] = $filteredUser["mailUser"];
            header("Location: http://localhost/OC5/user/profile");
        } else {
            echo "Error saving your profile.";
        }
    }

    public static function getNumberOfCommentsByUser($idUser){
        $query = "
        SELECT 
            COUNT(*) as commentCount
        FROM
            comment
        WHERE
            idUser = :idUser
        ";

        $params = [":idUser" => $idUser];
        $result = DbConnect::executeQuery($query, $params);

        // Retourner le nombre de commentaires de l'utilisateur
        return $result[0]['commentCount'];
    }
}