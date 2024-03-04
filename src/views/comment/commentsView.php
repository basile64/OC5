<div class="comments">
    <div class="title2">Commentaires</div>

    <div class="comments-container">
        <?= empty($mainComments) ? "Aucun commentaire." : ""; ?>
        <?php foreach ($mainComments as $mainComment) : ?>
            <div class="comment-container">
                <div class="main-comment-container">
                    <div class="main-comment-header">
                        <div class="main-comment-author"><?= $mainComment->getAuthor() ?></div>
                        <div class="main-comment-date"><?= $mainComment->getDate() ?></div>
                    </div>
                    <div class="main-comment-text"><?= $mainComment->getText() ?></div>
                </div>
                <?php require_once("../src/views/comment/responseCommentsView.php")?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
