    <div class="response-comments-container">
    <?php foreach ($mainComment->getResponseComments() as $responseComment) : ?>
        <div class="avatar-plus-header-response">
                <a class="avatar" href="http://localhost/OC5/user/<?= $responseComment->getUser()->getId() ?>"><img src="http://localhost/OC5/public/avatar/<?= $responseComment->getUser()->getAvatar() ?>" class="avatar"></a>
                <div class="response-comment-container">
                <div class="response-comment-header">
                    <div class="response-comment-author"><?= $responseComment->getUser()->getFirstName() ?> <?= ($responseComment->getUser()->getRole() == "admin")? " (Admin)" : "" ?></div>
                    <div class="response-comment-date"><?= $responseComment->getDate("d/m/Y") ?></div>
                </div>
                <div class="response-comment-text"><?= $responseComment->getText() ?></div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>