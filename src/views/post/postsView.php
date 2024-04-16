
<div class="title1">All my posts</div>

<div class="posts-container-list">
    <?php foreach ($posts as $post) { ?>
        <div class="post-container-list">
            <a href='/OC5/post/<?= htmlspecialchars($post->getId()) ?>'>
                <div class="post-top">
                    <img src="/OC5/public/upload/<?= htmlspecialchars($post->getImg()) ?>">
                    <div class="title-post-list"><?= htmlspecialchars($post->getTitle()) ?></div>
                    <div class="chapo-post-list"><?= htmlspecialchars($post->getChapo()) ?></div>
                    <div class="content-post-list"><?= strlen($post->getText()) > 200 ? substr(htmlspecialchars($post->getText()), 0, 200) . "..." : htmlspecialchars($post->getText()); ?></div>
                </div>
                <div class="post-bottom">
                    <div class="author-post-list"><?= htmlspecialchars($post->getUser()->getFirstName()) ?></div>
                    <div class="date-creation-post-list">
                    <?= htmlspecialchars(
                        ($post->getDateModification() != null) 
                        ? $post->getDateModification()->format("F j, Y") 
                        : $post->getDateCreation()->format("F j, Y")
                    ) ?>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
</div>

