<script src="http://localhost/OC5/public/js/main-layout.js"></script>

<div class="navbar">
    <div class="link-container-navbar">
        <a class='navbar-text' id="accueil" href="http://localhost/OC5" <?=(isset($page)&&$page=="home")?"style='font-weight:bold;'":""?>>Home</a>
        <a class='navbar-text' id="contact" href="http://localhost/OC5/contact"  <?=(isset($page)&&$page=="contact")?"style='font-weight:bold;'":""?>>Contact</a>
    </div>
    <div class="login-container-navbar">
        <?= isset($_SESSION["logged"]) ?
            "
            <a class='svg-plus-text' id='login' href='http://localhost/OC5/user/profile' " . (isset($page) && $page == "profileUser" ? "style='font-weight:bold;'" : "") . ">
                <img class='svg' src='http://localhost/OC5/public/svg/person.svg'/>
                <div class='navbar-text'>My profile</div>
            </a>
            " 
            : "<a id='logout' href='http://localhost/OC5/user/login'" . (isset($page) && $page == "loginUser" ? "style='font-weight:bold;'" : "") . ">Login</a>";
        ?>

        <?= (isset($_SESSION["logged"])&&($_SESSION["userRole"]=="admin")) ?
            "
            <a class='svg-plus-text' id='admin' href='http://localhost/OC5/admin/postsManagement'>
                <img class='svg' src='http://localhost/OC5/public/svg/gear.svg'/>
                <div class='navbar-text'>Manage</div>
            </a>
            "
            : ""
        ?>

        <?= isset($_SESSION["logged"]) ?
            "
            <a class='svg-plus-text' id='login' href='http://localhost/OC5/user/logout'>
                <img class='svg' src='http://localhost/OC5/public/svg/logout.svg'/>
                <div class='navbar-text'>Logout</div>
            </a>
            " 
            : "";
        ?>
    </div>
</div>

<div class="navbar-mobile">
    <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="link-navbar hidden">
        <div class="svg-plus-text">
                <img class='svg' src='http://localhost/OC5/public/svg/home.svg'/>
                <a id='accueil' href='http://localhost/OC5/home' <?= (isset($page) && $page == "home" ? "style='font-weight:bold;'" : "")?>>Home</a>
        </div>
        <div style='display:flex;align-items:center;gap:10px'>
                <img class='svg' src='http://localhost/OC5/public/svg/contact.svg'/>
                <a id='contact' href='http://localhost/OC5/contact' <?= (isset($page) && $page == "contact" ? "style='font-weight:bold;'" : "")?>>Contact</a>
        </div>
        <?= isset($_SESSION["logged"]) ?
            "
            <div class='svg-plus-text'>
                <img class='svg' src='http://localhost/OC5/public/svg/person.svg'/>
                <a id='login' href='http://localhost/OC5/user/profile' " . (isset($page) && $page == "profileUser" ? "style='font-weight:bold;'" : "") . ">My profile</a>
            </div>
            " 
            : "";
        ?>

        <?= (isset($_SESSION["logged"])&&($_SESSION["userRole"]=="admin")) ?
            "
            <div class='svg-plus-text'>
                <img class='svg' src='http://localhost/OC5/public/svg/gear.svg'/>
                <a id='admin' href='http://localhost/OC5/admin/postsManagement'>Manage</a>
            </div>
            "
            : ""
        ?>

        <?= isset($_SESSION["logged"]) ?
            "
            <div class='svg-plus-text'>
                <img class='svg' src='http://localhost/OC5/public/svg/logout.svg'/>
                <a id='login' href='http://localhost/OC5/user/logout'>Logout</a>
            </div>
            " 
            : "
            <div class='svg-plus-text'>
                <img class='svg' src='http://localhost/OC5/public/svg/login.svg'/>
                <a id='login' href='http://localhost/OC5/user/login'". (isset($page) && $page == "loginUser" ? "style='font-weight:bold;'" : "") . ">Login</a>
            </div>
            ";
        ?>
    </div>
</div>
