<?php ob_start()?>

<script src="http://localhost/OC5/public/js/post-single.js"></script>

<div class="single-post">
    <div class="nav-post">
        <a id="post-previous" href="">
            <img class="svg" src="http://localhost/OC5/public/img/arrow-left.svg"/>
        </a>
        <a id="post-next" href="">
            <img class="svg" src="http://localhost/OC5/public/img/arrow-right.svg"/>
        </a>
    </div>
    <div class="header-post-single">
        <div class="date-creation-post-single">Article écrit le <?=$post->getDateCreation("d/m/Y")?></div>
        <div class="date-creation-post-single">par <?=$post->getAuthor()?> </div>
    </div>

    <div class="post-container-single">
        <div class="title-post-single"><?=$post->getTitle()?></div>
        <div class="chapo-post-single"><?=$post->getChapo()?></div>
        <div class="text-post-single"><?=$post->getText()?></div>
    </div>

<?php require_once("../src/views/comment/mainCommentsByPostView.php");?>

</div>

<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");
