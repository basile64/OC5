<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="http://localhost/OC5/public/css/layout.css">
    <link rel="stylesheet" href="http://localhost/OC5/public/css/post-list.css">
    <link rel="stylesheet" href="http://localhost/OC5/public/css/post-single.css">
    <link rel="stylesheet" href="http://localhost/OC5/public/css/comment.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="navbar">
        <div class="link-container-navbar">
            <a id="accueil" href="">Accueil</a>
            <a id="contact" href="">Contact</a>
        </div>
        <div class="login-container-navbar">
            <a id="mon-compte" href=""> Mon compte</a>
        </div>
    </div>

    <div id ="content">
        <?= $content ?>
    </div>
    
</body>
</html>