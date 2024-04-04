<?php ob_start()?>

<script src="http://localhost/OC5/public/js/post-single.js"></script>
<link rel="stylesheet" href="http://localhost/OC5/public/css/comment.css">

<div class="single-post">
    <div class="header-post-single">
        <a id="post-previous" href="">
            <img class="svg" src="http://localhost/OC5/public/svg/arrow-left.svg"/>
        </a>
        <div class="date-creation-post-single"><?=$post->getDateCreation("d/m/Y") ?><div style="font-weight:bold; margin-left:20px">by <?=$post->getUser()->getFirstName()?></div></div>
        <a id="post-next" href="">
            <img class="svg" src="http://localhost/OC5/public/svg/arrow-right.svg"/>
        </a>
    </div>

    <div class="post-container-single">
        <img src="/OC5/public/upload/<?= $post->getImg() ?>">
        <div class="title-post-single"><?=$post->getTitle()?></div>
        <div class="chapo-post-single"><?=$post->getChapo()?></div>
        <div class="text-post-single"><?=$post->getText()?></div>
    </div>

<?php require_once("../src/views/comment/mainCommentsByPostView.php");?>

</div>

<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");
