<?php

ob_start();

$page = "usersManagement";

?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-list-management.css">

<div class="users-header">
    <div class="title1">Users</div>
    <a id="add-user" href="/OC5/admin/usersManagement/new">Create a new user</a>
</div>

<div class="users-container-list">
    <?php
    foreach ($users as $user) { ?>
        <div class="user-container-list">
            <div class="user-container">
                <div class="title-user-list"><?php echo($user->getFirstName() . " " . $user->getLastName())?></div>
                <div class="right-user-list">
                    <div class="date-creation-user-list"><?= $user->getDateRegistration("d/m/Y") ?></div>
                    <a href="/OC5/user/<?= $user->getIdUser() ?>"><img class="svg" src="http://localhost/OC5/public/img/arrow-up.svg"/></a>
                    <a href="/OC5/admin/usersManagement/delete/<?= $user->getIdUser() ?>" style="background-color:#de0404"><img class="svg" src="http://localhost/OC5/public/img/trash.svg"/></a>
                    <a href="/OC5/admin/usersManagement/edit/<?= $user->getIdUser() ?>" style="background-color:#2020cf"><img class="svg" src="http://localhost/OC5/public/img/pencil.svg"/></a>
                </div>
             </div>
        </div>
    <?php } ?>
</div>

<?php

$content = ob_get_clean();

require_once("../src/views/adminLayout.php");