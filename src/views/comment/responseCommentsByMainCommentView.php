<div class="response-comments-container">
    <?php foreach ($mainComment->getResponseComments() as $responseComment) : ?>
        <div class="avatar-plus-header-response">
            <a class="avatar" href="<?= BASE_URL ?>user/<?= htmlspecialchars($responseComment->getUser()->getId()) ?>"><img src="<?= BASE_URL ?>public/avatar/<?= htmlspecialchars($responseComment->getUser()->getAvatar()) ?>" class="avatar"></a>
            <div class="response-comment-container">
                <div class="response-comment-header">
                    <div class="response-comment-author"><?= htmlspecialchars($responseComment->getUser()->getFirstName()) ?> <?= ($responseComment->getUser()->getRole() === "admin")? " (Admin)" : "" ?></div>
                    <div class="response-comment-date"><?= htmlspecialchars($responseComment->getDate("F j, Y")) ?></div>
                </div>
                <div class="response-comment-text"><?= htmlspecialchars($responseComment->getText()) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
