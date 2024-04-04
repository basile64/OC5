<div class="comments">
    <div class="title2">Comments</div>

    <div class="comments-container">
        <?= empty($post->getMainComments()) ? "No comments." : ""; ?>
        <?php foreach ($post->getMainComments() as $mainComment) :?>
            <div class="comment-container" id="comment<?=$mainComment->getIdMainComment()?>">
                <div class="avatar-plus-header-main">
                    <img src="http://localhost/OC5/public/avatar/<?= $mainComment->getUser()->getAvatar() ?>" class="avatar">
                    <div class="main-comment-container">
                        <div class="main-comment-header">
                            <div class="main-comment-author"><?= $mainComment->getUser()->getFirstName() ?></div>
                            <div class="main-comment-date"><?= $mainComment->getDate("d/m/Y") ?></div>
                        </div>
                        <div class="main-comment-text"><?= $mainComment->getText() ?></div>
                    </div>
                </div>
                <?php require("../src/views/comment/responseCommentsByMainCommentView.php")?>
                <?php 
                    if (isset($_SESSION["logged"])){
                        require("../src/views/comment/newResponseCommentView.php");
                    }
                ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php 
        if (isset($_SESSION["logged"])){
            require_once("../src/views/comment/newMainCommentView.php");
        } else {
            echo "<div style='margin-top:50px'>You must be connected to post a comment.</div>";
        }
    ?>
</div>
