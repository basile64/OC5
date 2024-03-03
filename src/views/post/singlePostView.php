<?php ob_start()?>

<div class="header-post-single">
    <div class="date-creation-post-single">Article écrit le <?=$post["dateCreationPost"]?></div>
    <div class="date-creation-post-single">par <?=$post["authorPost"]?> </div>
</div>

<div class="post-container-single">
    <div class="title-post-single"><?=$post["titlePost"]?></div>
    <div class="chapo-post-single"><?=$post["chapoPost"]?></div>
    <div class="text-post-single"><?=$post["textPost"]?></div>
</div>

<div class="comments">
    <div class="title2">Commentaires</div>

    <div class="comments-container">
    <?=empty($comments) ? "Aucun commentaire.":"";?>
    <?php foreach ($comments as $comment) {?>
        <div class="comment-container">
            <div class="header-comment">
                <div class="author-comment"><?=$comment["authorComment"]?></div>
                <div class="date-comment"><?=$comment["dateComment"]?></div>
            </div>
            <div class="text-comment"><?=$comment["textComment"]?></div>
        </div>
    <?php } ?>
    </div>
</div>
<?php

$content = ob_get_clean();

require_once("../views/layout.php");
