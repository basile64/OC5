<?php

ob_start();

$page = "home";

?>

<link rel="stylesheet" href="http://localhost/OC5/public/css/homepage.css">

<div class="banner">
    <div class="banner-overlay"></div>
    <div class="banner-text">
        <div class="banner-text-1">Basile Pineau,</div>
        <div class="banner-text-2">the creative mind your project needs !</div>
    </div>
    <img class="logo" src="http://localhost/OC5/public/img/logo.png">
</div>


<?php require_once "../src/views/post/postsView.php";?>


<?php

$content = ob_get_clean();

require_once "../src/views/mainLayout.php";