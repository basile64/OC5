<?php 
ob_start();
$page = "usersManagement";
?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-new.css">

<div class="user">

    <form method="post" action="./create">
    <div class="title2">Create a new user</div>
        <input id="input-first-name-user" name="firstNameUser" type="text" placeholder="First name"/>
        <input id="input-last-name-user" name="lastNameUser" type="text" placeholder="Last name"/>
        <input id="input-mail-user" name="mailUser" type="text" placeholder="Email name"/>
        <input id="input-password-user" name="passwordUser" type="text" placeholder="Password"/>
        <select id="select-role-user" name="roleUser">
            <option value="Basic" selected disabled>Choose a role</option>
            <option value="Basic">Basic</option>
            <option value="Admin">Admin</option>
        </select>
        <button type="submit" id="btn-edit-user" name="submit">Validate the creation</button>
    </form>
</div>

</div>

<?php

$content = ob_get_clean();

require_once("../src/views/adminEditLayout.php");
