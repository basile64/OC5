<?php

namespace application\src\controllers;
use application\src\utils\SessionManager;

class Controller
{ 

    protected $sessionManager;
    protected $view;

    public function __construct()
    {
        $this->sessionManager = new SessionManager;
    }

    protected function render($data = [])
    {
        $data['sessionManager'] = $this->sessionManager;
        extract($data);

        require_once "../src/views/$this->view.php";
    }
}
