<?php ob_start()?>
<?php $currentUrl = htmlspecialchars($_SERVER['REQUEST_URI']);?>

<script src="http://localhost/OC5/public/js/post-single.js"></script>
<link rel="stylesheet" href="http://localhost/OC5/public/css/comment.css">

<div class="single-post">
    <div class="header-post-single">
        <a id="post-previous" href="<?= htmlspecialchars($currentUrl) ?>/getPrevious">
            <img class="svg" src="http://localhost/OC5/public/svg/arrow-left.svg"/>
        </a>
        <div class="date-creation-post-single">
            <?= ($post->getDateModification() != null) ? "Edited on " . htmlspecialchars($post->getDateModification()->format("F j, Y")) : htmlspecialchars($post->getDateCreation()->format("F j, Y")) ?> <div style="font-weight:bold;">by <?= htmlspecialchars($post->getUser()->getFirstName()) ?></div>
        </div>
        <a id="post-next" href="<?= htmlspecialchars($currentUrl) ?>/getNext">
            <img class="svg" src="http://localhost/OC5/public/svg/arrow-right.svg"/>
        </a>
    </div>

    <div class="post-container-single">
        <img src="/OC5/public/upload/<?= htmlspecialchars($post->getImg()) ?>">
        <div class="title-post-single"><?= htmlspecialchars($post->getTitle()) ?></div>
        <div class="chapo-post-single"><?= htmlspecialchars($post->getChapo()) ?></div>
        <div class="text-post-single"><?= htmlspecialchars($post->getText()) ?></div>
    </div>

<?php require_once "../src/views/comment/mainCommentsByPostView.php";?>

</div>

<?php

$content = ob_get_clean();

require_once "../src/views/mainLayout.php";
