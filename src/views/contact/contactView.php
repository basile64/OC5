<?php

ob_start();

$page = "contact";

?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/contact.css">

<div class="contact">

    <form method="post" action="http://localhost/OC5/contact">
        <div class="title1">Contact us</div>
        <div style="margin-bottom:10px">We generally respond within 24 hours.</div>
        <input class="contact-input" name="firstNameUser" type="text" placeholder="Your first name"/>
        <input class="contact-input" name="lastNameUser" type="text" placeholder="Your last name"/>
        <input class="contact-input" name="emailUser" type="email" placeholder="Your email"/>
        <textarea class="contact-input" name="messageUser" placeholder="Your message"></textarea>
        <button type="submit" id="btn-login-user" name="submit">Send</button>
    </form>
        
    </div>

<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");