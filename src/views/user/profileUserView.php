<?php

ob_start();

$page = "profileUser";

?>
<!-- CSS -->
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-profile.css">
<!-- JS -->
<script src="/OC5/public/js/profile-user.js"></script>

<div class="container1">
    <div class="tabs">
        <a href="profile" class="selected">My profile</a>
        <a href="comments">My comments</a>
        <a href="password">My password</a>
    </div>
    <div class="container2">
        <div class="information">
            <form method="post" action="./save" enctype="multipart/form-data">
                <img src="http://localhost/OC5/public/avatar/<?= htmlspecialchars($user->getAvatar()) ?>" class="avatar" id="avatarPreview">
                <div>
                    <div class="label">Select an avatar</div>
                    <input type="file" name="userAvatar" id="avatarUser" accept="image/*">
                </div>
                <div>
                    <div class="label">First name</div>
                    <input id="input-first-name-user" name="userFirstName" type="text" value="<?= htmlspecialchars($user->getFirstName()) ?>" placeholder="First name"/>
                </div>
                <div>
                    <div class="label">Last name</div>
                    <input id="input-last-name-user" name="userLastName" type="text" value="<?= htmlspecialchars($user->getLastName()) ?>"placeholder="Last name"/>
                </div>
                <div>
                    <div class="label">Email</div>
                    <input id="input-mail-user" name="userMail" type="text" value="<?= htmlspecialchars($user->getMail()) ?>" placeholder="Email name"/>
                </div>
                <button type="submit" id="btn-save-user" name="submit">Save my information</button>
            </form>
        </div>
    </div>
</div>
<?php

$content = ob_get_clean();

require_once "../src/views/mainLayout.php";
