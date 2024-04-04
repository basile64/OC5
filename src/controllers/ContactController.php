<?php

namespace application\src\controllers;

use application\src\models\post\PostManager;
use application\src\models\comment\MainCommentManager;
use application\src\models\comment\ResponseCommentManager;
use application\src\models\comment\MainComment;
use application\src\utils as Util;

class ContactController extends Controller{

    public function __construct($explodedUrl){
        $this->showContactPage();
    }

    public function showContactPage(){
        $this->view = "contactView";
        $this->render();
    }
}
