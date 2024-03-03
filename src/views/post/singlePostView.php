<?php ob_start()?>

<div class="header-post-single">
    <div class="date-creation-post-single">Article écrit le <?=$post->getDateCreation()?></div>
    <div class="date-creation-post-single">par <?=$post->getAuthor()?> </div>
</div>

<div class="post-container-single">
    <div class="title-post-single"><?=$post->getTitle()?></div>
    <div class="chapo-post-single"><?=$post->getChapo()?></div>
    <div class="text-post-single"><?=$post->getText()?></div>
</div>

<?php require_once("../src/views/comment/commentsView.php");?>

<?php

$content = ob_get_clean();

require_once("../src/views/layout.php");
