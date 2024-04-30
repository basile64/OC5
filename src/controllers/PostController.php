<?php

namespace application\src\controllers;

use application\src\models\post\PostManager;
use application\src\models\comment\MainCommentManager;
use application\src\models\comment\ResponseCommentManager;
use application\src\models\comment\MainComment;

class PostController extends Controller
{
    
    /**
     * The manager instance for handling post-related operations.
     *
     * @var PostManager
     */
    private $postManager;

    /**
     * The manager instance for handling main comment-related operations.
     *
     * @var MainCommentManager
     */
    private $mainCommentManager;

    /**
     * The manager instance for handling response comment-related operations.
     *
     * @var ResponseCommentManager
     */
    private $responseCommentManager;

    /**
     * Constructor method.
     * 
     * Initializes a new instance of the PostController class.
     * Determines action based on the provided URL.
     * 
     * @param array $explodedUrl The exploded URL parts.
     */
    public function __construct($explodedUrl)
    {
        parent::__construct(); 

        // Check if URL represents a single post or a navigation action
        if (is_numeric($explodedUrl[1]) === true && isset($explodedUrl[2]) === false){
            $idPost = $explodedUrl[1];
            $this->showSingle($idPost);
        // For getNextPost and getPreviousPost actions
        } else if (isset($explodedUrl[2])) {
            $idPost = $explodedUrl[1];
            $action = $explodedUrl[2];
            if (method_exists($this, $action) === true) {
                $this->$action($idPost);
            } else {
                header("Location: ".BASE_URL);
            }
        } else {
            header("Location: ".BASE_URL);
        }
    }

    /**
     * Displays all posts.
     */
    public function showPosts()
    {
        // Get all posts
        $this->postManager = new PostManager();
        $posts = $this->postManager->getAll();

        // Set view and render posts page
        $this->view = "post/postsView";
        $this->render(["posts" => $posts]);
    }

    /**
     * Displays a single post.
     *
     * @param int $postId The ID of the post.
     */
    public function showSingle($postId)
    {
        // Get post details
        $this->postManager = new PostManager();
        $post = $this->postManager->get($postId);

        // Get main comments for the post
        $this->mainCommentManager = new MainCommentManager();
        $mainComments = $this->mainCommentManager->getAllApprovedByPostId($postId);

        // Set view and render single post page
        $this->view = "post/singlePostView";
        $this->render(["post"=> $post]);
    }

    /**
     * Redirects to the next post.
     *
     * @param int $postId The ID of the current post.
     */
    private function getNext($postId)
    {
        // Get next post ID
        $this->postManager = new PostManager();
        $nextPost = $this->postManager->getNext($postId);
        $nextPostId = $nextPost->getId();

        // Redirect to the next post if available; otherwise, display error message
        if ($nextPostId !== null) {
            header("Location: ".BASE_URL."post/".$nextPostId);
        } else {
            $this->sessionManager->setSessionVariable("error_message", "This is the last post.");
            header("Location: ".BASE_URL."post/".$postId);
        }
    }

    /**
     * Redirects to the previous post.
     *
     * @param int $postId The ID of the current post.
     */
    private function getPrevious($postId)
    {
        // Get previous post ID
        $this->postManager = new PostManager();
        $previousPost = $this->postManager->getPrevious($postId);
        $previousPostId = $previousPost->getId();

        // Redirect to the previous post if available; otherwise, display error message
        if ($previousPostId !== null) {
            header("Location: ".BASE_URL."post/".$previousPostId);
        } else {
            $this->sessionManager->setSessionVariable("error_message", "This is the first post.");
            header("Location: ".BASE_URL."post/".$postId);
        }
    }
}
