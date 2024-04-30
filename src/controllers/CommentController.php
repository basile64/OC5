<?php

namespace application\src\controllers;

use application\src\models\database\DbConnect;
use application\src\models\comment\Comment;
use application\src\models\comment\CommentManager;
use application\src\models\comment\MainCommentManager;
use application\src\models\comment\ResponseCommentManager;

class CommentController extends Controller
{
    
    /**
     * Manager instance for handling comments.
     *
     * @var CommentManager
     */
    private $commentManager;

    /**
     * Manager instance for handling main comments.
     *
     * @var MainCommentManager
     */
    private $mainCommentManager;

    /**
     * Manager instance for handling response comments.
     *
     * @var ResponseCommentManager
     */
    private $responseCommentManager;

    /**
     * The class being managed.
     *
     * @var string
     */
    private $class;

    /**
     * The action to be performed on the current class.
     *
     * @var string
     */
    private $action;

    /**
     * Constructor of the class.
     *
     * Initializes a new instance of the class with the provided parameters.
     * If the user is logged in, sets the class and action based on the URL segments and executes the corresponding action.
     * Otherwise, sets an error message and redirects to the home page.
     *
     * @param array $explodedUrl An array representing a URL split into segments.
     * @return void
     */
    public function __construct($explodedUrl)
    {
        parent::__construct(); 

        // Check if the user is logged in
        if ($this->sessionManager->getSessionVariable("logged") === true) {
            // Set the class and action based on URL segments
            $this->class = $explodedUrl[0];
            $this->action = $explodedUrl[1];

            // Execute the specified action
            $this->runAction();
            return;
        }

        // Set error message and redirect to home page if user is not logged in
        $this->sessionManager->setSessionVariable("error_message", "You have to be logged.");
        header("Location: ".BASE_URL);
        return;
    }

    /**
     * Executes the specified action method based on the current action property value.
     *
     * @return void
     */
    private function runAction()
    {
        // Dynamically call the specified action method
        $this->{$this->action . "Comment"}();
    }

    /**
     * Creates a new comment.
     *
     * Creates a new comment using the CommentManager instance.
     * If the comment creation is successful, checks if it's a response to another comment.
     * If not, creates a new main comment using MainCommentManager.
     * Otherwise, creates a new response comment using ResponseCommentManager.
     *
     * @return void
     */
    private function createComment()
    {
        // Create a new instance of CommentManager
        $this->commentManager = new CommentManager();

        // Check if comment creation is successful
        if ($this->commentManager->{$this->action}() === true) {
            // Get the ID of the last inserted comment
            $commentId = DbConnect::$connection->lastInsertId();

            // Check if it's a response to another comment
            $mainCommentId = filter_input(INPUT_POST, 'mainCommentId', FILTER_VALIDATE_INT);

            // If not a response, create a new main comment
            if ($mainCommentId === null) {
                $this->mainCommentManager = new MainCommentManager();
                $this->mainCommentManager->create($commentId);
                return;
            }
            
            // If it's a response, create a new response comment
            $this->responseCommentManager = new ResponseCommentManager();
            $this->responseCommentManager->create($commentId);
        }
    }
}
