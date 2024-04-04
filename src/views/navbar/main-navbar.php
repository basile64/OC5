<div class="navbar">
    <div class="link-container-navbar">
        <a id="accueil" href="http://localhost/OC5" <?=(isset($page)&&$page=="home")?"style='font-weight:bold;'":""?>>Home</a>
        <a id="contact" href="http://localhost/OC5/contact"  <?=(isset($page)&&$page=="contact")?"style='font-weight:bold;'":""?>>Contact</a>
    </div>
    <div class="login-container-navbar">
        <?= isset($_SESSION["logged"]) ?
            "
            <div style='display:flex;align-items:center;gap:10px'>
                <img class='svg' src='http://localhost/OC5/public/svg/person.svg'/>
                <a id='login' href='http://localhost/OC5/user/profile' " . (isset($page) && $page == "profileUser" ? "style='font-weight:bold;'" : "") . ">My profile</a>
            </div>
            <div style='display:flex;align-items:center;gap:10px'>
                <img class='svg' src='http://localhost/OC5/public/svg/logout.svg'/>
                <a id='login' href='http://localhost/OC5/user/logout'>Logout</a>
            </div>
            " 
            : "<a id='logout' href='http://localhost/OC5/user/login'" . (isset($page) && $page == "loginUser" ? "style='font-weight:bold;'" : "") . ">Login</a>";
        ?>
        <?= (isset($_SESSION["logged"])&&($_SESSION["roleUser"]=="admin")) ?
            "
            <div style='display:flex;align-items:center;gap:10px'>
                <img class='svg' src='http://localhost/OC5/public/svg/gear.svg'/>
                <a id='admin' href='http://localhost/OC5/admin/postsManagement'>Manage</a>
            </div>
            "
            : ""
        ?>
    </div>
</div>
