    <div class="response-comments-container">
    <?php foreach ($mainComment->getResponseComments() as $responseComment) : ?>
        <div class="response-comment-container">
            <div class="response-comment-header">
                <div class="response-comment-author"><?= $responseComment->getAuthor() ?></div>
                <div class="response-comment-date"><?= $responseComment->getDate("d/m/Y") ?></div>
            </div>
            <div class="response-comment-text"><?= $responseComment->getText() ?></div>
        </div>
    <?php endforeach; ?>
    </div>