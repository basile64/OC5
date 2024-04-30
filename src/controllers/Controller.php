<?php

namespace application\src\controllers;

use application\src\utils\SessionManager;

class Controller
{ 

    /**
     * Instance of SessionManager for handling session-related operations.
     *
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * View to be rendered.
     *
     * @var string
     */
    protected $view;

    /**
     * Constructor method.
     * 
     * Initializes a new instance of the Controller class.
     * Initializes a new SessionManager instance.
     */
    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }

    /**
     * Renders the view with optional data.
     *
     * @param array $data Optional data to be passed to the view.
     */
    protected function render($data = [])
    {
        // Pass SessionManager instance to view
        $data['sessionManager'] = $this->sessionManager;
        extract($data);

        // Render view
        require_once "../src/views/$this->view.php";
    }
}
