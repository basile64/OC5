
<div class="title1">All my posts</div>

<div class="posts-container-list">
    <?php
    foreach ($posts as $post) { ?>
        <div class="post-container-list">
            <a href='/OC5/post/<?= $post->getId() ?>'>
                <div class="post-top">
                    <img src="/OC5/public/upload/<?= $post->getImg() ?>">
                    <div class="title-post-list"><?= $post->getTitle() ?></div>
                    <div class="chapo-post-list"><?= $post->getChapo() ?></div>
                    <div class="content-post-list"><?= strlen($post->getText()) > 200 ? substr($post->getText(), 0, 200) . "..." : $post->getText(); ?></div>
                </div>
                    <div class="post-bottom">
                    <div class="author-post-list"><?= $post->getUser()->getFirstName() ?></div>
                    <div class="date-creation-post-list"><?= $post->getDateCreation("d-m-Y") ?></div>
                </div>
            </a>
        </div>
    <?php } ?>
</div>
