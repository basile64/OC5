
<div class="title1">My posts</div>

<div class="posts-container-list">
    <?php
    foreach ($posts as $post) { ?>
        <div class="post-container-list">
            <a href='/OC5/post/<?= $post->getId() ?>'>
                <div class="title-post-list"><?= $post->getTitle() ?></div>
                <div class="chapo-post-list"><?= $post->getChapo() ?></div>
                <div class="content-post-list"><?= strlen($post->getText()) > 200 ? substr($post->getText(), 0, 200) . "..." : $post->getText(); ?></div>
            </a>
            <div class="author-post-list"><?= $post->getAuthor() ?></div>
            <div class="date-creation-post-list"><?= $post->getDateCreation() ?></div>
        </div>
    <?php } ?>
</div>
