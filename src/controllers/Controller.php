<?php

namespace application\src\controllers;

class Controller{
    protected function render($view, $data = []){
        extract($data);

        require_once("../src/views/$view.php");
    }
}