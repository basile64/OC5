<?php
ob_start();
?>
<!-- CSS -->
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-public-profile.css">
<!-- JS -->
<script src="/OC5/public/js/profile-user.js"></script>

<div class="container1">
    <div class="title2">Profile of <?= htmlspecialchars($user->getFirstName()) ?> <?= htmlspecialchars($user->getLastName()) ?></div>
    <div class="container2">
        <div class="information">
            <form method="post" action="./save" enctype="multipart/form-data">
                <img src="http://localhost/OC5/public/avatar/<?= htmlspecialchars($user->getAvatar()) ?>" class="avatar" id="avatarPreview">
                <div>
                    <div class="label">Role</div>
                    <div><?= ucfirst(htmlspecialchars($user->getRole())) ?></div>
                </div>
                <div>
                    <div class="label">First name</div>
                    <div><?= htmlspecialchars($user->getFirstName()) ?></div>
                </div>
                <div>
                    <div class="label">Last name</div>
                    <div><?= htmlspecialchars($user->getLastName()) ?></div>
                </div>
                <div>
                    <div class="label">Number of comments</div>
                    <div><?= htmlspecialchars($numberOfComments) ?></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

$content = ob_get_clean();

require_once "../src/views/mainLayout.php";
