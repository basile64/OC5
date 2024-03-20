<?php

ob_start();

$page = "commentsManagement";

?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/comment-list-management.css">

<div class="comments-header">
    <div class="title1">Comments</div>
</div>

<div class="comments-container-list">
    <?php
    foreach ($comments as $comment) :?>
        <div class="comment-container-list">
            <div class="comment-container">
                <div class="title-comment-list"><?= $comment->getText() ?></div>
                <div class="right-comment-list">
                    <div class="date-comment-list"><?= $comment->getDate("d/m/Y") ?></div>
                    <a href="/OC5/post/<?= $comment->getIdPost() ?>"><img class="svg" src="http://localhost/OC5/public/img/arrow-up.svg"/></a>
                    <a href="/OC5/admin/commentsManagement/approve/<?= $comment->getIdComment() ?>" style="background-color:green"><img class="svg" src="http://localhost/OC5/public/img/check.svg"/></a>
                    <a href="/OC5/admin/commentsManagement/delete/<?= $comment->getIdComment() ?>" style="background-color:#de0404"><img class="svg" src="http://localhost/OC5/public/img/close.svg"/></a>
                </div>
            </div>
            <!-- <div class="author-comment-list"><?= $comment->getAuthor() ?></div> -->
        </div>
    <?php endforeach; ?>
</div>

<?php

$content = ob_get_clean();

require_once("../src/views/adminLayout.php");