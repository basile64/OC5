<?php

ob_start();

$page = "profileUser";

?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-profile.css">

<div class="container1">
    <div class="tabs">
        <a href="profile">My profile</a>
        <a href="comments" class="selected">My comments</a>
        <a href="password">My password</a>
    </div>
    <div class="container2">
        <div class="comments-container-list">
            <?php
            echo(empty($comments) ? "No comments." : "");
            foreach ($comments as $comment) :?>
                <div class="comment-container-list">
                    <div class="comment-container">
                        <div class="title-comment-list"><?= $comment->getText() ?></div>
                        <div class="right-comment-list">
                            <div class="date-comment-list"><?= $comment->getDate("d/m/Y") ?></div>
                            <a href="/OC5/post/<?= $comment->getIdPost() ?>"><img class="svg" src="http://localhost/OC5/public/svg/arrow-up.svg"/></a>
                            <a href="/OC5/user/comments/delete/<?= $comment->getIdComment() ?>" style="background-color:#de0404"><img class="svg" src="http://localhost/OC5/public/svg/close.svg"/></a>
                        </div>
                    </div>
                    <!-- <div class="author-comment-list"><?= $comment->getUser()->getFirstName()?></div> -->
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");