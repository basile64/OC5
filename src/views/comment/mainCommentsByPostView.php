<div class="comments">
    <div class="title2">Comments</div>

    <div class="comments-container">
        <?= empty($post->getMainComments()) ? "No comments." : ""; ?>
        <?php foreach ($post->getMainComments() as $mainComment) :?>
            <div class="comment-container" id="comment<?= htmlspecialchars($mainComment->getMainCommentId()) ?>">
                <div class="avatar-plus-header-main">
                    <a class="avatar" href="<?= htmlspecialchars(BASE_URL) ?>user/<?= htmlspecialchars($mainComment->getUser()->getId()) ?>"><img src="<?= htmlspecialchars(BASE_URL) ?>public/avatar/<?= htmlspecialchars($mainComment->getUser()->getAvatar()) ?>" class="avatar"></a>
                    <div class="main-comment-container">
                        <div class="main-comment-header">
                            <div class="main-comment-author"><?= htmlspecialchars($mainComment->getUser()->getFirstName()) ?> <?= ($mainComment->getUser()->getRole() === "admin")? " (Admin)" : "" ?></div>
                            <div class="main-comment-date"><?= htmlspecialchars($mainComment->getDate("F j, Y")) ?></div>
                        </div>
                        <div class="main-comment-text"><?= htmlspecialchars($mainComment->getText()) ?></div>
                    </div>
                </div>
                <?php require("../src/views/comment/responseCommentsByMainCommentView.php")?>
                <?php 
                    if ($sessionManager->getSessionVariable("logged") === true){
                        require("../src/views/comment/newResponseCommentView.php");
                    }
                ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php 
        if ($sessionManager->getSessionVariable("logged") === true){
            require_once "../src/views/comment/newMainCommentView.php";
        } else {
    ?>
            <div style='margin-top:50px'>You must be connected to post a comment.</div>
    <?php
        }
    ?>
</div>
