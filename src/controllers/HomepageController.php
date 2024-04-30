<?php

namespace application\src\controllers;

use application\src\models\post\PostManager;

class HomepageController extends Controller
{

    /**
     * The manager instance for handling post-related operations.
     *
     * @var PostManager
     */
    private $postManager;

    /**
     * Constructor method.
     * 
     * Initializes a new instance of the HomepageController class.
     * Shows the home page.
     */
    public function __construct()
    {
        parent::__construct(); 
        $this->showHomePage();
    }

    /**
     * Displays the home page.
     */
    public function showHomePage()
    {
        // Get all posts
        $this->postManager = new PostManager();
        $posts = $this->postManager->getAll();

        // Set view and render home page
        $this->view = "homepageView";
        $this->render(["posts" => $posts, "sessionManager" => $this->sessionManager]);
    }
}
