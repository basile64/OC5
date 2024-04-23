<?php

ob_start();

$page = "commentsManagement";

?>
<link rel="stylesheet" href="<?= htmlspecialchars(BASE_URL) ?>public/css/comment-list-management.css">

<div class="comments-header">
    <div class="title1">Comments</div>
</div>

<div class="comments-container-list">
    <?php
    echo(empty($comments) ? "No new comments." : "");
    foreach ($comments as $comment) :?>
        <div class="comment-container-list">
            <div class="comment-container">
                <div class="title-comment-list"><?= htmlspecialchars($comment->getText()) ?></div>
                <div class="right-comment-list">
                    <div class="date-comment-list"><?= htmlspecialchars($comment->getDate("F j, Y")) ?></div>
                    <div class="icons">
                        <a href="/OC5/post/<?= htmlspecialchars($comment->getPostId()) ?>"><img class="svg" src="<?= htmlspecialchars(BASE_URL) ?>public/svg/arrow-up.svg"/></a>
                        <a href="/OC5/admin/commentsManagement/approve/<?= htmlspecialchars($comment->getCommentId()) ?>" style="background-color:green"><img class="svg" src="<?= htmlspecialchars(BASE_URL) ?>public/svg/check.svg"/></a>
                        <a href="/OC5/admin/commentsManagement/delete/<?= htmlspecialchars($comment->getCommentId()) ?>" style="background-color:#de0404"><img class="svg" src="<?= htmlspecialchars(BASE_URL) ?>public/svg/close.svg"/></a>
                    </div>               
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php

$content = ob_get_clean();

require_once "../src/views/adminLayout.php";