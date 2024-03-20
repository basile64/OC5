<?php 
ob_start();
$page = "usersManagement";
?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-new.css">

<div class="user">
<form method="post" action="../update/<?=$user->getIdUser()?>">
        <div class="title2">Edit the user</div>
        <input id="input-first-name-user" name="firstNameUser" type="text" value="<?=$user->getFirstName()?>" placeholder="First name"/>
        <input id="input-last-name-user" name="lastNameUser" type="text"  value="<?=$user->getLastName()?>" placeholder="Last name"/>
        <input id="input-mail-user" name="mailUser" type="text"  value="<?=$user->getMail()?>" placeholder="Email"/>
        <input id="input-password-user" name="passwordUser" type="text"  value="<?=$user->getPassword()?>" placeholder="Password"/>
        <input id="input-date-registration-user" name="dateRegistrationUser" type="date"  value="<?=$user->getDateRegistration()?>"/>
        <select id="select-role-user" name="roleUser">
            <option value="Basic" <?=($user->getRole()=="basic")?"selected":""?>>Basic</option>
            <option value="Admin" <?=($user->getRole()=="admin")?"selected":""?>>Admin</option>
        </select>
        <button type="submit" id="btn-edit-user" name="submit">Sauvegarder les modifications</button>
    </form>
</div>

</div>

<?php

$content = ob_get_clean();

require_once("../src/views/adminEditLayout.php");
