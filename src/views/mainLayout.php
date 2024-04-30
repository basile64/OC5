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

    <link rel="stylesheet" href="<?= htmlspecialchars(BASE_URL) ?>public/css/main-layout.css">
    <link rel="stylesheet" href="<?= htmlspecialchars(BASE_URL) ?>public/css/post-list-homepage.css">
    <link rel="stylesheet" href="<?= htmlspecialchars(BASE_URL) ?>public/css/post-single.css">
    <link rel="stylesheet" href="<?= htmlspecialchars(BASE_URL) ?>public/css/footer.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?= ($sessionManager->getSessionVariable("logged") === true && $sessionManager->getSessionVariable("userEmailConfirmed") === 0) ?
    "<div class='email-confirmed'>Your email adress isn't confirmed. Check your mails !</div>"
    : ""?>
    <?php require_once "../src/views/navbar/main-navbar.php";?>

    <div id ="content">
        <?= $content ?>
    </div>

    <?php require_once "../src/views/footer.php";?>
    
</body>
</html>