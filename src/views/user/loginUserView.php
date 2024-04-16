<?php 
ob_start();

$page = "loginUser";

?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-login.css">

<div class="login">

<form method="post" action="./connect">
    <div class="title2">Login to access your account</div>
        <input id="input-mail-user" name="userMail" type="email" placeholder="Email" value="<?= $_SESSION["formData"]['userMail'] ?? ''?>"/>
        <input id="input-password-user" name="userPassword" type="password" placeholder="Password"/>
        <button type="submit" id="btn-login-user" name="submit">Login</button>
        <a id="register" href="register">Register</a>
    </form>
    
</div>

<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");
