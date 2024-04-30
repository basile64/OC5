<?php

namespace application\src\models\user;

use application\src\models\database\DbConnect;
use application\src\models\user\User;
use application\src\utils\SessionManager;
use application\src\models\contact\ContactManager;
use application\src\models\file\FileManager;
use application\src\models\file\File;

/**
 * Provides methods to manage user entity.
 */
class UserManager
{

    /**
     * Manages session-related operations such as setting and getting session variables.
     *
     * @var SessionManager
     */
    public $sessionManager;

    /**
     * Manages the sending of emails.
     *
     * @var contactManager
     */
    public $contactManager;

    /**
     * UserManager constructor.
     */
    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }

    /**
     * Get all users.
     *
     * @return array An array of User objects representing all users.
     */
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

        $users = [];
        foreach ($result as $userData) {
            $user = new User($userData);
            $users[] = $user;
        }

        return $users;
    }

    /**
     * Get all admin users.
     *
     * @return array An array of User objects representing all admin users.
     */
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

        $users = [];
        foreach ($result as $userData) {
            $user = new User($userData);
            $users[] = $user;
        }

        return $users;
    }

    /**
     * Get all basic users.
     *
     * @return array An array of User objects representing all basic users.
     */
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

        $users = [];
        foreach ($result as $userData) {
            $user = new User($userData);
            $users[] = $user;
        }

        return $users;
    }

    /**
     * Get a user by their ID.
     *
     * @param int $id The ID of the user to retrieve.
     * @return User|null The User object if found, otherwise null.
     */
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

    /**
     * Register a new user.
     *
     * @return void
     */
    public function register()
    {
        return null;
    }

    /**
     * Create a new user.
     *
     * @return void
     */
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
            header("Location: ".BASE_URL."user/register");
            return;
        }
    
        if ($this->checkIfEmailExists($email)) {
            $this->sessionManager->setSessionVariable("error_message", "An account with this email address already exists.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".BASE_URL."user/register");
            return;
        }
    
        if ($password != $confirmPassword){
            $this->sessionManager->setSessionVariable("error_message", "Passwords do not match.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".BASE_URL."user/register");
            return;
        }
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $query="
            INSERT 
            INTO
                user (firstName, lastName, mail, password, dateRegistration, token)
            VALUES
                (:firstName, :lastName, :mail, :password, NOW(), :token)
        ";

        $token = $this->generateToken();
    
        $params = [
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":mail" => $email,
            ":password" => $hashedPassword,
            ":token" => $token
        ];
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result === false) {
            $this->sessionManager->setSessionVariable("error_message", "Error creating your account.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".BASE_URL."user/register");
            return;
        }

        $this->sessionManager->setSessionVariable("success_message", "Your account is created.");
        $this->sessionManager->unsetSessionVariable("formData");
        $this->contactManager = new ContactManager;
        $this->contactManager->sendEmailConfirmation($firstName, $email, $token);
        header("Location: ".BASE_URL."user/login");
        return;
    }

    /**
     * Generate a unique token.
     *
     * @return string
     */
    private function generateToken() {
        // Generate a random string using PHP's built-in functions
        $token = bin2hex(random_bytes(32)); // 32 bytes = 64 hexadecimal characters
        return $token;
    }

    /**
     * Confirm the email address of the user using the provided token.
     * 
     * @param string $token The token used for email confirmation.
     * @return void
     */
    public function confirmEmail($explodedUrl) {
        $token = $explodedUrl[2];
        $user = $this->getUserByToken($token);
    
        if ($user === null) {
            $this->sessionManager->setSessionVariable("error_message", "Invalid token.");
            header("Location: ".BASE_URL);
            return;
        } 
        $query = "UPDATE user SET emailConfirmed = 1 WHERE id = :userId";
        $params = [":userId" => $user->getId()];
        DbConnect::executeQuery($query, $params);

        $this->sessionManager->setSessionVariable("success_message", "Your email is confirmed.");
        $this->sessionManager->setSessionVariable("userEmailConfirmed", 1);
        header("Location: ".BASE_URL);
        return;
    }
    
    /**
     * Retrieve a user from the database by token.
     *
     * @param string $token The token used to retrieve the user.
     * @return User|null Returns the user object if found, or null if not found.
     */
    private function getUserByToken($token) {
        $query = "SELECT * FROM user WHERE token = :token";
        $params = [":token" => $token];
        $result = DbConnect::executeQuery($query, $params);
        if ($result) {
            return new User($result[0]);
        } else {
            return null;
        }
    }

    /**
     * Check if an email already exists in the database.
     *
     * @param string $mail The email address to check.
     * @return bool True if the email exists, otherwise false.
     */
    public function checkIfEmailExists($mail)
    {
        $query = "
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

        return count($result) >= 1;
    }

    /**
     * Retrieves and returns the user with the given ID.
     *
     * @param int $id The ID of the user to retrieve.
     * @return User|null The user object if found, otherwise null.
     */
    public function edit($id)
    {
        return $this->get($id);
    }

    /**
     * Updates the user information in the database.
     *
     * @param int $id The ID of the user to update.
     * @return void
     */
    public function update($id)
    {
        // Retrieving user data from the POST request
        $firstName = filter_input(INPUT_POST, "userFirstName", FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, "userLastName", FILTER_SANITIZE_STRING);
        $mail = filter_input(INPUT_POST, "userMail", FILTER_VALIDATE_EMAIL);
        $role = filter_input(INPUT_POST, "userRole", FILTER_SANITIZE_STRING);
    
        // Checking if all fields are filled
        if ($firstName === null || $lastName === null || $mail === null || $role === null) {
            $this->sessionManager->setSessionVariable("error_message", "All fields are required.");
            header("Location: ".BASE_URL."admin/usersManagement/edit/".$id);
            return;
        }
    
        // Updating user information in the database
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
            header("Location: ".BASE_URL."admin/usersManagement");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error updating user.");
            header("Location: ".BASE_URL."admin/usersManagement/edit/".$id);
            return;
        }
    }

    /**
     * Deletes the user with the given ID from the database.
     *
     * @param int $id The ID of the user to delete.
     * @return void
     */
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
            header("Location: ".BASE_URL."admin/usersManagement");
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Error when deleting the user !");
            header("Location: ".BASE_URL."admin/usersManagement");
            return;
        }
    }

    /**
     * Initiates the login process for the user.
     *
     * @return void
     */
    public function login()
    {
        return null;
    }

    /**
     * Attempts to authenticate the user based on provided credentials.
     *
     * @return void
     */
    public function connect()
    {
        // Retrieving user credentials from the POST request
        $userMail = filter_input(INPUT_POST, "userMail", FILTER_VALIDATE_EMAIL);
        $userPassword = $_POST["userPassword"];
    
        // Validating email format
        if ($userMail === null) {
            $this->sessionManager->setSessionVariable("error_message", "Invalid email format.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".BASE_URL."user/login");
            return;
        }
    
        // Retrieving user data from the database
        $query="
            SELECT 
                *
            FROM
                user
            WHERE
                mail = :mail 
        ";
        $params = [":mail" => $userMail];
        $userData = DbConnect::executeQuery($query, $params)[0];
    
        // Authenticating user
        if ($userData != NULL && password_verify($userPassword, $userData['password'])) {
            $this->sessionManager->setSessionVariable("success_message", "Connected !");
            $this->sessionManager->setSessionVariable("logged", true);

            $this->openSession($userData);
            $this->sessionManager->unsetSessionVariable("formData");
            header("Location: ".BASE_URL);
            return;
        } else {
            $this->sessionManager->setSessionVariable("error_message", "Incorrect email or password.");
            $this->sessionManager->setSessionVariable("formData", filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
            header("Location: ".BASE_URL."user/login");
            return;
        }
    }

    /**
     * Opens a session for the authenticated user.
     *
     * @param array $userData The data of the authenticated user.
     * @return void
     */
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
        $this->sessionManager->setSessionVariable("userEmailConfirmed", $user->getEmailConfirmed());
    }

    /**
     * Logs out the currently logged-in user.
     *
     * @return void
     */
    public function logout()
    {
        session_unset();
        header("Location: ".BASE_URL);
    }

    /**
     * Retrieves and returns the profile information of the currently logged-in user.
     *
     * @return User|null The user object representing the profile of the currently logged-in user, or null if no user is logged in.
     */
    public function profile()
    {
        $user = $this->get($this->sessionManager->getSessionVariable("userId"));
        return $user;
    }

    /**
     * Placeholder method.
     *
     * @return void
     */
    public function password()
    {
        return null;
    }

    /**
     * Updates the user's password in the database.
     *
     * @return void
     */
    public function changePassword()
    {
        // Retrieving user ID
        $userId = $this->sessionManager->getSessionVariable("userId");
        $user = $this->get($userId);
    
        // Retrieving old, new, and confirmed passwords
        $oldPassword = $_POST["oldPassword"];
        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];
    
        // Sanitizing password inputs
        $oldPassword = filter_var($oldPassword, FILTER_SANITIZE_STRING);
        $newPassword = filter_var($newPassword, FILTER_SANITIZE_STRING);
        $confirmPassword = filter_var($confirmPassword, FILTER_SANITIZE_STRING);
    
        // Validating old password
        if (!password_verify($oldPassword, $user->getPassword())) {
            $this->sessionManager->setSessionVariable("error_message", "Incorrect old password.");
            header("Location: ".BASE_URL."user/password");
            return;
        }
    
        // Checking if new password matches the confirmation
        if ($newPassword !== $confirmPassword) {
            $this->sessionManager->setSessionVariable("error_message", "New password and confirmation do not match.");
            header("Location: ".BASE_URL."user/password");
            return;
        }
    
        // Hashing the new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        // Updating password in the database
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
            header("Location: ".BASE_URL."user/change-password");
            return;
        }

        $this->sessionManager->setSessionVariable("success_message", "Password successfully updated.");
        header("Location: ".BASE_URL."user/profile");
        return;
    }

    /**
     * Saves the user's profile information in the database.
     *
     * @return void
     */
    public function save()
    {
        // Retrieving user and current avatar
        $user = $this->get($this->sessionManager->getSessionVariable("userId"));
        $currentAvatar = $user->getAvatar();
    
        // Retrieving form inputs
        $firstName = filter_input(INPUT_POST, "userFirstName", FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, "userLastName", FILTER_SANITIZE_STRING);
        $mail = filter_input(INPUT_POST, "userMail", FILTER_VALIDATE_EMAIL);        
    
        // Checking if all fields are filled
        if ($firstName === null || $lastName === null || $mail === null) {
            $this->sessionManager->setSessionVariable("error_message", "All fields are required.");
            header("Location: ".BASE_URL."user/profile");
            return;
        }
    
        $this->fileManager = new FileManager;
    
        // Checking if an avatar file is uploaded
        if ($this->fileManager->isFileUploaded("userAvatar") === true) {
            // Creating a File instance for the avatar
            $avatarFile = new File("userAvatar");
    
            // Checking if the file exists
            if ($this->fileManager->fileExists("userAvatar") === false) {
                $this->sessionManager->setSessionVariable("error_message", "Avatar file doesn't exist.");
                header("Location: ".BASE_URL."user/profile");
                return;
            }
    
            // Allowed avatar file extensions
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if ($this->fileManager->isAllowedFileType($avatarFile, $allowedExtensions) === false) {
                $this->sessionManager->setSessionVariable("error_message", "Only JPG, JPEG, PNG, and GIF files are allowed for avatars.");
                header("Location: ".BASE_URL."user/profile");
                return;
            }
    
            // Moving the uploaded avatar file to the avatar directory
            $uploadDir = "../public/avatar/";
            $avatarName = $this->fileManager->generateUniqueFilename($avatarFile->getName());
            if ($this->fileManager->moveUploadedFile($avatarFile, $uploadDir, $avatarName) === false) {
                $this->sessionManager->setSessionVariable("error_message", "Error uploading the avatar.");
                header("Location: ".BASE_URL."user/profile");
                return;
            }
        } else {
            // Using the current avatar if no file is submitted
            $avatarName = $currentAvatar;
        }
    
        // Constructing the SQL query to update user data
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
            ":avatar" => $avatarName,
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":mail" => $mail,
            ":id" => $this->sessionManager->getSessionVariable("userId")
        ];
    
        $result = DbConnect::executeQuery($query, $params);
    
        if ($result === false) {
            $this->sessionManager->setSessionVariable("error_message", "Error saving your profile.");
            header("Location: ".BASE_URL."user/profile");
            return;
        }
        
        $this->sessionManager->setSessionVariable("success_message", "Profile updated !");
        $this->sessionManager->setSessionVariable("userAvatar", $avatarPath);
        $this->sessionManager->setSessionVariable("userFirstName", $firstName);
        $this->sessionManager->setSessionVariable("userLastName", $lastName);
        $this->sessionManager->setSessionVariable("userMail", $mail);            
        header("Location: ".BASE_URL."user/profile");
    }
    
    /**
     * Retrieves the number of comments posted by the user with the given ID.
     *
     * @param int $id The ID of the user.
     * @return int The number of comments posted by the user.
     */
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

        // Returning the number of comments posted by the user
        return $result[0]['commentCount'];
    }

}
