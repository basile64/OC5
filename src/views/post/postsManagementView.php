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
    <?php foreach ($posts as $post) { ?>
        <div class="post-container-list">
            <div class="post-container">
                <div class="title-post-list"><?= htmlspecialchars($post->getTitle()) ?></div>
                <div class="right-post-list">
                    <div class="date-creation-post-list"><?= htmlspecialchars($post->getDateCreation()->format("F j, Y")) ?></div>
                    <div class="icons">
                        <a href="/OC5/post/<?= htmlspecialchars($post->getId()) ?>"><img class="svg" src="http://localhost/OC5/public/svg/arrow-up.svg"/></a>
                        <a href="/OC5/admin/postsManagement/delete/<?= htmlspecialchars($post->getId()) ?>" style="background-color:#de0404"><img class="svg" src="http://localhost/OC5/public/svg/trash.svg"/></a>
                        <a href="/OC5/admin/postsManagement/edit/<?= htmlspecialchars($post->getId()) ?>" style="background-color:#2020cf"><img class="svg" src="http://localhost/OC5/public/svg/pencil.svg"/></a>
                    </div>
                </div>
             </div>
        </div>
    <?php } ?>
</div>


<?php

$content = ob_get_clean();

require_once("../src/views/adminLayout.php");