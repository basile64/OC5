<?php

namespace application\src\models\user;

use application\src\models\database\DbConnect;
use application\src\models\user\User;
use application\src\models\user\BasicUser;
use application\src\models\user\AdminUser;


class UserManager {

    public function getAll(){
        $query = "
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

    public function getUser($idUser){
        $query = "
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
                idUser = :idUser
        ";

        $params = [":idUser" => $idUser];
        $result = DbConnect::executeQuery($query, $params);

        $user = new User($result[0]);

        return $user;

    }

    public function newUser(){
        //Pas besoin de retourner une variable, la vue nous suffit
        return null;
    }

    public function createUser(){
        $newUser = array_map("htmlspecialchars", $_POST);

        $query="
            INSERT 
            INTO
                user (firstNameUser, lastNameUser, mailUser, passwordUser, dateRegistrationUser, roleUser)
            VALUES
                (:firstNameUser, :lastNameUser, :mailUser, :passwordUser, NOW(), :roleUser)
        ";

        $params = [
            ":firstNameUser" => $newUser["firstNameUser"],
            ":lastNameUser" => $newUser["lastNameUser"],
            ":mailUser" => $newUser["mailUser"],
            ":passwordUser" => $newUser["passwordUser"],
            ":roleUser" => $newUser["roleUser"]
        ];
        //Insertion table User
        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $_SESSION["success_message"] = "User created.";
            header("Location: http://localhost/OC5/admin/usersManagement");
            exit();
        }else{
            echo "Error creating user.";
        }
    }

    public function editUser($idUser){
        return ($this->getUser($idUser));
    }

    public function updateUser($idUser){
        $query ="
            UPDATE
                user
            SET
                firstNameUser = :firstNameUser,
                lastNameUser = :lastNameUser,
                mailUser = :mailUser,
                passwordUser = :passwordUser,
                roleUser = :roleUser
            WHERE
                idUser = :idUser
        ";

        if (isset($_POST)){
        $params = [":firstNameUser" => $_POST["firstNameUser"], ":lastNameUser" => $_POST["lastNameUser"], ":mailUser" => $_POST["mailUser"], ":passwordUser" => $_POST["passwordUser"], ":roleUser" => $_POST["roleUser"], ":idUser" => $idUser];
        }

        $result = DbConnect::executeQuery($query, $params);

        if ($result !== false) {
            $_SESSION["success_message"] = "Utilisateur modifié avec succès.";
            header("Location: http://localhost/OC5/admin/usersManagement");
            exit();
        } else {
            echo "Erreur lors de la modification de l'utilisateur.";
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
                mailUser = :mailUser AND passwordUser = :passwordUser
        ";
        $params = [":mailUser" => $mailUser, ":passwordUser" => $passwordUser];
        $userData = DbConnect::executeQuery($query, $params)[0];

        if ($userData != NULL){
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
        $_SESSION["dateRegistrationUser"] = $user->getDateRegistration();
        $_SESSION["roleUser"] = $user->getRole();
    }
    
    public function logoutUser(){
        session_unset();
        header("Location: http://localhost/OC5/");
    }



}