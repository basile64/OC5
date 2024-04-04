<?php

ob_start();

$page = "profileUser";

?>
<!-- CSS -->
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-public-profile.css">
<!-- JS -->
<script src="/OC5/public/js/profile-user.js"></script>

<div class="container1">
    <div class="title2">Profile of <?=$user->getFirstName()?> <?=$user->getLastName()?></div>
    <div class="container2">
        <div class="information">
                <form method="post" action="./save" enctype="multipart/form-data">
                    <img src="http://localhost/OC5/public/avatar/<?= $user->getAvatar() ?>" class="avatar" id="avatarPreview">
                    <div>
                        <div class="label">First name</div>
                        <div><?=$user->getFirstName()?></div>
                    </div>
                    <div>
                        <div class="label">Last name</div>
                        <div><?=$user->getLastName()?></div>
                    </div>
                    <div>
                        <div class="label">Number of comments</div>
                        <div><?=$numberOfComments?></div>
                    </div>
                </form>
        </div>
    </div>
</div>
<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");