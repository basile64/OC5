<div class="navbar">
    <div class="link-container-navbar">
        <a id="accueil" href="http://localhost/OC5" <?=(isset($page)&&$page=="home")?"style='font-weight:bold;'":""?>>Home</a>
        <a id="contact" href="" <?=(isset($page)&&$page=="contact")?"style='font-weight:bold;'":""?>>Contact</a>
    </div>
    <div class="login-container-navbar">
        <a id="login" href="http://localhost/OC5/user/login">Login</a>
        <a id="admin" href="http://localhost/OC5/admin/postsManagement">Admin</a>
    </div>
</div>