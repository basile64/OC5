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
        <a href="profile">My profile</a>
        <a href="comments">My comments</a>
        <a href="password" class="selected">My password</a>
    </div>
    <div class="container2">
        <div class="information">
                <form method="post" action="./changePassword" enctype="multipart/form-data">
                    <div>
                        <div class="label">Old password</div>
                        <input id="old-password" name="oldPassword" type="password" placeholder="Current password"/>
                    </div>
                    <div>
                        <div class="label">New password</div>
                        <input id="new-password" name="newPassword" type="password" placeholder="New password"/>
                    </div>
                    <div>
                        <div class="label">Confirm your new password</div>
                        <input id="confirm-password" name="confirmPassword" type="password" placeholder="Confirm your new password"/>
                    </div>
                    <button type="submit" id="btn-save-user" name="submit">Save the new password</button>
                </form>
        </div>
    </div>
</div>
<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");