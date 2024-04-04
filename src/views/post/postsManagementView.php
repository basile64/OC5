<?php

ob_start();

$page = "postsManagement";

?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/post-list-management.css">

<div class="posts-header">
    <div class="title1">Posts</div>
    <a id="add-post" href="/OC5/admin/postsManagement/new">Create a new post</a>
</div>

<div class="posts-container-list">
    <?php
    foreach ($posts as $post) { ?>
        <div class="post-container-list">
            <div class="post-container">
                <div class="title-post-list"><?= $post->getTitle() ?></div>
                <div class="right-post-list">
                    <div class="date-creation-post-list"><?= $post->getDateCreation("d/m/Y") ?></div>
                    <a href="/OC5/post/<?= $post->getId() ?>"><img class="svg" src="http://localhost/OC5/public/svg/arrow-up.svg"/></a>
                    <a href="/OC5/admin/postsManagement/delete/<?= $post->getId() ?>" style="background-color:#de0404"><img class="svg" src="http://localhost/OC5/public/svg/trash.svg"/></a>
                    <a href="/OC5/admin/postsManagement/edit/<?= $post->getId() ?>" style="background-color:#2020cf"><img class="svg" src="http://localhost/OC5/public/svg/pencil.svg"/></a>
                </div>
                <!-- <div class="chapo-post-list"><?= $post->getChapo() ?></div>
                <div class="content-post-list"><?= strlen($post->getText()) > 200 ? substr($post->getText(), 0, 200) . "..." : $post->getText(); ?></div> -->
    </div>
            <!-- <div class="author-post-list"><?= $post->getUser()->getFirstName() ?></div> -->
        </div>
    <?php } ?>
</div>

<?php

$content = ob_get_clean();

require_once("../src/views/adminLayout.php");