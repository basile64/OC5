<?php

ob_start();

$page = "profileUser";

?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-profile.css">

<div class="profile">

        <form method="post" action="./save">
        <div class="title2">My profile</div>
            <input id="input-first-name-user" name="firstNameUser" type="text" value="<?=$_SESSION['firstNameUser']?>" placeholder="First name"/>
            <input id="input-last-name-user" name="lastNameUser" type="text" value="<?=$_SESSION['lastNameUser']?>"placeholder="Last name"/>
            <input id="input-mail-user" name="mailUser" type="text" value="<?=$_SESSION['mailUser']?>" placeholder="Email name"/>
            <button type="submit" id="btn-edit-user" name="submit">Save my information</button>
        </form>

</div>

<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");