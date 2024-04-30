<?php

namespace application\src\controllers;

use application\src\models\post\PostManager;
use application\src\models\comment\CommentManager;
use application\src\models\user\UserManager;
use application\src\models\category\CategoryManager;

use application\src\utils as Util;

class AdminController extends Controller
{
    
    /**
     * The current class being managed.
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
     * Action constant for editing.
     *
     * @var string
     */
    private const ACTION_EDIT = "edit";

    /**
     * Action constant for updating.
     *
     * @var string
     */
    private const ACTION_UPDATE = "update";

    /**
     * Action constant for deleting.
     *
     * @var string
     */
    private const ACTION_DELETE = "delete";

    /**
     * Action constant for creating a new instance.
     *
     * @var string
     */
    private const ACTION_NEW = "new";

    /**
     * Action constant for creating a new instance.
     *
     * @var string
     */
    private const ACTION_CREATE = "create";

    /**
     * The manager instance for handling data operations.
     *
     * @var mixed
     */
    private $manager;

    /**
     * The key used to access data in the rendered view.
     *
     * @var string
     */
    private $dataKey;

    /**
     * The manager instance for handling category-related operations.
     *
     * @var mixed
     */
    private $categoryManager;

    /**
     * The manager instance for handling user-related operations.
     *
     * @var mixed
     */
    private $userManager;

    /**
     * Constructor of the class.
     *
     * Initializes a new instance of the class with the provided parameters.
     * This constructor takes an array representing a URL split into segments and
     * performs necessary actions based on the user's role and URL segments.
     *
     * @param array $explodedUrl An array representing a URL split into segments.
     * @return void
     */
    public function __construct($explodedUrl)
    {
        parent::__construct(); 
        array_shift($explodedUrl);
        $this->class = str_replace("sManagement", "", $explodedUrl[0]);
        if (count($explodedUrl) === 1 && $this->sessionManager->getSessionVariable("userRole") === "admin"){
            $this->loadClassManagement($this->class);
            return; 
        }
        if (count($explodedUrl) > 1 && $this->sessionManager->getSessionVariable("userRole") === "admin") {
            $this->action = $explodedUrl[1];
            $this->runAction($explodedUrl);
            return; 
        }
        header("Location: ".BASE_URL);
        return;
    }

    /**
     * Loads the appropriate management class based on the current class property value.
     * Sets necessary properties such as manager, view, and dataKey accordingly.
     * Invokes the loadManagement method to load data for rendering.
     *
     * @return void
     */
    private function loadClassManagement(){
        switch ($this->class) {
            case "post":
                $this->manager = new PostManager;
                $this->view = "post/postsManagementView";
                $this->dataKey = "posts";
                break;
            case "comment":
                $this->manager = new CommentManager;
                $this->view = "comment/commentsManagementView";
                $this->dataKey = "comments";
                break;
            case "user":
                $this->manager = new UserManager;
                $this->view = "user/usersManagementView";
                $this->dataKey = "users";
                break;
            default:
                break;
        }
        $this->loadManagement();
    }
    
    /**
     * Loads data for rendering based on the current class and action.
     * If the class is not 'comment', retrieves all data using the manager's 'getAll' method.
     * Otherwise, retrieves only pending data using the manager's 'getAllPending' method.
     * Renders the retrieved data using the render method.
     *
     * @return void
     */
    private function loadManagement()
    {
        if ($this->class !== "comment") {
            $data = [$this->dataKey => $this->manager->getAll()];
        } else {
            $data = [$this->dataKey => $this->manager->getAllPending()];
        }
        $this->render($data);
    }
    
    /**
     * Runs the specified action on the current manager instance.
     * Retrieves the action name and optionally the ID from the URL segments.
     * Instantiates the appropriate manager class based on the current class property value.
     * Calls the specified action method on the manager instance with the optional ID parameter.
     * Renders the result if the action involves editing or adding a new post/user.
     *
     * @param array $explodedUrl The array containing URL segments.
     * @return void
     */
    private function runAction($explodedUrl)
    {
        $id = ($explodedUrl[2] ?? null);

        $managerClassName = "application\src\models\\".$this->class."\\".ucfirst($this->class)."Manager";

        $actionName = $this->action;

        $this->manager = new $managerClassName();
        if ($id !== null) {
            $result = $this->manager->{$actionName}($id);
        } else {
            $result = $this->manager->{$actionName}();
        }

        // Nous avons besoin d'une vue s'il faut éditer ou ajouter un nouveau post/utilisateur
        if ($this->action === self::ACTION_EDIT || $this->action === self::ACTION_NEW){
            $this->view = $this->class . "/" . $this->action . ucfirst($this->class) . "View";
            $this->manager = new PostManager();
            $this->categoryManager = new CategoryManager;
            $categories = $this->categoryManager->getAll();
            $this->userManager = new UserManager;
            $authors = $this->userManager->getAllAdmin();
            $this->render([$this->class => $result, "categories" => $categories, "authors" => $authors]);
        }
    }

}
