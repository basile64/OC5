<?php

ob_start();

$page = "contact";

?>

<link rel="stylesheet" href="<?= BASE_URL ?>public/css/contact.css">
<script src="<?= BASE_URL ?>public/js/contact.js"></script>

<div class="contact">

    <form method="post" action="<?= BASE_URL ?>contact">
        <div class="title1">Contact us</div>
        <div style="margin-bottom:10px">We generally respond within 24 hours.</div>
        <input class="contact-input" name="userFirstName" type="text" placeholder="Your first name" value="<?= $formData['userFirstName'] ?? '' ?>" />
        <input class="contact-input" name="userLastName" type="text" placeholder="Your last name" value="<?= $formData['userLastName'] ?? '' ?>" />
        <input class="contact-input" name="userEmail" type="email" placeholder="Your email" value="<?= $formData['userEmail'] ?? '' ?>" />
        <textarea class="contact-input" name="userMessage" placeholder="Your message"><?= $formData['userMessage'] ?? '' ?></textarea>
        <button type="submit" id="btn-login-user" name="submit">Send</button>
    </form>
        
</div>

<?php

$content = ob_get_clean();

require_once "../src/views/mainLayout.php";
