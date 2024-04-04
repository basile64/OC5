<?php 
ob_start();
$page = "usersManagement";
?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-edit.css">

<div class="user">
<form method="post" action="../update/<?=$user->getId()?>">
        <div class="title2">Edit the user</div>
        <div class="container">
            <div class="label">First name</div>
            <input id="input-first-name-user" name="firstNameUser" type="text" value="<?=$user->getFirstName()?>" placeholder="First name"/>
        </div>
        <div class="container">
            <div class="label">Last name</div>
        <input id="input-last-name-user" name="lastNameUser" type="text"  value="<?=$user->getLastName()?>" placeholder="Last name"/>
        </div>
        <div class="container">
            <div class="label">Email</div>
        <input id="input-mail-user" name="mailUser" type="text"  value="<?=$user->getMail()?>" placeholder="Email"/>
        </div>
        <div class="container">
            <div class="label">Role</div>
            <select id="select-role-user" name="roleUser">
                <option value="Basic" <?=($user->getRole()=="basic")?"selected":""?>>Basic</option>
                <option value="Admin" <?=($user->getRole()=="admin")?"selected":""?>>Admin</option>
            </select>
        </div>  
        <button type="submit" id="btn-edit-user" name="submit">Save</button>
    </form>
</div>

</div>

<?php

$content = ob_get_clean();

require_once("../src/views/adminEditLayout.php");
