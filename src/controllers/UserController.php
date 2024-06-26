<?php

namespace application\src\controllers;

use application\src\models\database\DbConnect;
use application\src\models\user\User;
use application\src\models\user\UserManager;
use application\src\models\comment\CommentManager;
use application\src\models\user\BasicUserManager;
use application\src\models\user\AdminUserManager;

class UserController extends Controller
{

    /**
     * The manager instance for handling user-related operations.
     *
     * @var UserManager
     */
    private $userManager;

    /**
     * The manager instance for handling comment-related operations.
     *
     * @var CommentManager
     */
    private $commentManager;

    /**
     * Class representing the type of user-related action.
     *
     * @var string
     */
    private $class;

    /**
     * Action to be performed on the user-related entity.
     *
     * @var string
     */
    private $action;

    public function __construct($explodedUrl)
    {
        parent::__construct(); 
        $this->class = $explodedUrl[0];
            if (isset($explodedUrl[2]) && $explodedUrl[2]==="delete" && isset($explodedUrl[3]) && is_numeric($explodedUrl[3])){
                $this->commentManager = new CommentManager();
                $this->commentManager->delete($explodedUrl[3]);
            } elseif (isset($explodedUrl[1])) {
                $this->action = $explodedUrl[1];
                $this->runAction($explodedUrl);
            }
    }

    private function runAction($explodedUrl)
    {
        if ($this->action != "comments"){
            $this->userManager = new UserManager();
            //C as pour afficher un profil public
            if (is_numeric($explodedUrl[1]) === true){
                $user = $this->userManager->get($explodedUrl[1]);
                $numberOfComments = $this->userManager->getNumberOfCommentsByUser($user->getId());
                $this->view = $this->class . "/" . "publicProfile" . ucfirst($this->class) . "View";
                $this->render([$this->class => $user, "numberOfComments" => $numberOfComments]);
            } else {
                $result = $this->userManager->{$this->action}($explodedUrl);
                $this->view = $this->class . "/" . $this->action . ucfirst($this->class) . "View";
                $this->render([$this->class => $result]);
            }
        } else {
            $this->commentManager = new CommentManager();
            $result = $this->commentManager->getAllApprovedByUser(); 
            $this->view = $this->class . "/" . $this->action . ucfirst($this->class) . "View";
            $this->render(["comments" => $result]);
        }
    }

}