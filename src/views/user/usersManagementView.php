<?php

ob_start();

$page = "usersManagement";

?>
<link rel="stylesheet" href="<?= BASE_URL ?>public/css/user-list-management.css">


<div class="title1">Users</div>
<div class="users-container-list">
    <?php
    foreach ($users as $user) { ?>
        <div class="user-container-list">
            <div class="user-container">
                <div class="title-user-list"><?= htmlspecialchars($user->getFirstName() . " " . $user->getLastName())?></div>
                <div class="right-user-list">
                    <div class="date-creation-user-list"><?= $user->getDateRegistration("F j, Y") ?></div>
                    <div class="icons">
                        <a href="/OC5/user/<?= htmlspecialchars($user->getId()) ?>"><img class="svg" src="<?= BASE_URL ?>public/svg/arrow-up.svg"/></a>
                        <a href="/OC5/admin/usersManagement/delete/<?= htmlspecialchars($user->getId()) ?>" style="background-color:#de0404"><img class="svg" src="<?= BASE_URL ?>public/svg/trash.svg"/></a>
                        <a href="/OC5/admin/usersManagement/edit/<?= htmlspecialchars($user->getId()) ?>" style="background-color:#2020cf"><img class="svg" src="<?= BASE_URL ?>public/svg/pencil.svg"/></a>
                    </div>
                </div>
             </div>
        </div>
    <?php } ?>
</div>


<?php

$content = ob_get_clean();

require_once "../src/views/adminLayout.php";