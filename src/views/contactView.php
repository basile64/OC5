<?php

ob_start();

$page = "contact";

?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/contact.css">

<div class="contact">

    <form method="post" action="./connect">
        <div class="title1">Contact us</div>
            <input class="contact-input" name="firstNameUser" type="text" placeholder="Your first name"/>
            <input class="contact-input" name="lastNameUser" type="text" placeholder="Your last name"/>
            <textarea class="contact-input" name="text" placeholder="Your message"></textarea>
            <button type="submit" id="btn-login-user" name="submit">Send</button>
        </form>
        
    </div>

<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");