<div class="comments">
    <div class="title2">Commentaires</div>

    <div class="comments-container">
    <?=empty($comments) ? "Aucun commentaire.":"";?>
    <?php foreach ($comments as $comment) {?>
        <div class="comment-container">
            <div class="header-comment">
                <div class="author-comment"><?=$comment->getAuthor()?></div>
                <div class="date-comment"><?=$comment->getDate()?></div>
            </div>
            <div class="text-comment"><?=$comment->getText()?></div>
        </div>
    <?php } ?>
    </div>
</div>