<?php 
ob_start();
$page = "login";
?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-register.css">

<div class="user">
    <form method="post" action="./create">
        <div class="title2">Create your account</div>
        <input class="input-register" id="input-first-name-user" name="firstNameUser" type="text" placeholder="First name"/>
        <input class="input-register" id="input-last-name-user" name="lastNameUser" type="text" placeholder="Last name"/>
        <input class="input-register" id="input-mail-user" name="mailUser" type="text" placeholder="Email name"/>
        <input class="input-register" id="input-password-user" name="passwordUser" type="password" placeholder="Password"/>
        <input class="input-register" id="input-confirm-password-user" name="confirmPasswordUser" type="password" placeholder="Confirm your password"/>
        <button type="submit" id="btn-create-user" name="submit">Validate the creation</button>
    </form>
</div>

</div>

<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");
