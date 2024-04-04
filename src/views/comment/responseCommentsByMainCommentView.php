    <div class="response-comments-container">
    <?php foreach ($mainComment->getResponseComments() as $responseComment) : ?>
        <div class="avatar-plus-header-response">
            <img src="http://localhost/OC5/public/avatar/<?= $responseComment->getUser()->getAvatar() ?>" class="avatar">
                <div class="response-comment-container">
                <div class="response-comment-header">
                    <div class="response-comment-author"><?= $responseComment->getUser()->getFirstName() ?></div>
                    <div class="response-comment-date"><?= $responseComment->getDate("d/m/Y") ?></div>
                </div>
                <div class="response-comment-text"><?= $responseComment->getText() ?></div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>