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
    <title>OC5</title>

    <link rel="stylesheet" href="http://localhost/OC5/public/css/admin-layout.css">
    <link rel="stylesheet" href="http://localhost/OC5/public/css/post-single.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php require_once("../src/views/navbar/admin-navbar.php");?>

    <div id ="content">
        <?= $content ?>
    </div>
    
</body>
</html>