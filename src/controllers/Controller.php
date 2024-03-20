<?php

namespace application\src\controllers;

class Controller{ 
    protected $view;

    protected function render($data = []){
        extract($data);

        require_once("../src/views/$this->view.php");
    }
}
