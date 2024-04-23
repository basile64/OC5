<script src="<?= BASE_URL ?>public/js/main-layout.js"></script>

<div class="navbar">
    <div class="link-container-navbar">
        <a class='navbar-text' id="accueil" href="http://localhost/OC5" <?=(isset($page)&&$page=="home")?"style='font-weight:bold;'":""?>>Home</a>
        <a class='navbar-text' id="contact" href="<?= BASE_URL ?>contact"  <?=(isset($page)&&$page=="contact")?"style='font-weight:bold;'":""?>>Contact</a>
    </div>
    <div class="login-container-navbar">
        <?= ($sessionManager->getSessionVariable("logged") === true) ?
            "
            <a class='svg-plus-text' id='login' href='".BASE_URL."user/profile'".(isset($page) && $page == "profileUser" ? "style='font-weight:bold;'" : "").">
                <img class='svg' src='".BASE_URL."public/svg/person.svg'/>
                <div class='navbar-text'>My profile</div>
            </a>
            " 
            : "<a class='navbar-text' id='logout' href='".BASE_URL."user/login'".(isset($page) && $page == "loginUser" ? "style='font-weight:bold;'" : "").">Login</a>";
        ?>

        <?= (($sessionManager->getSessionVariable("logged") === true)  && ($sessionManager->getSessionVariable("userRole") === "admin")) ?
            "
            <a class='svg-plus-text' id='admin' href='".BASE_URL."admin/postsManagement'>
                <img class='svg' src='".BASE_URL."public/svg/gear.svg'/>
                <div class='navbar-text'>Manage</div>
            </a>
            "
            : ""
        ?>

        <?= ($sessionManager->getSessionVariable("logged") === true) ?
            "
            <a class='svg-plus-text' id='login' href='".BASE_URL."user/logout'>
                <img class='svg' src='".BASE_URL."public/svg/logout.svg'/>
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
                <img class='svg' src='<?= BASE_URL ?>public/svg/home.svg'/>
                <a id='accueil' href='<?= BASE_URL ?>home' <?= (isset($page) && $page == "home" ? "style='font-weight:bold;'" : "")?>>Home</a>
        </div>
        <div style='display:flex;align-items:center;gap:10px'>
                <img class='svg' src='<?= BASE_URL ?>public/svg/contact.svg'/>
                <a id='contact' href='<?= BASE_URL ?>contact' <?= (isset($page) && $page == "contact" ? "style='font-weight:bold;'" : "")?>>Contact</a>
        </div>
        <?= ($sessionManager->getSessionVariable("logged") === true) ?
            "
            <div class='svg-plus-text'>
                <img class='svg' src='".BASE_URL."public/svg/person.svg'/>
                <a id='login' href='".BASE_URL."user/profile' " . (isset($page) && $page == "profileUser" ? "style='font-weight:bold;'" : "") . ">My profile</a>
            </div>
            " 
            : "";
        ?>

        <?= (($sessionManager->getSessionVariable("logged") === true)  && ($sessionManager->getSessionVariable("userRole") === "admin")) ?
            "
            <div class='svg-plus-text'>
                <img class='svg' src='".BASE_URL."public/svg/gear.svg'/>
                <a id='admin' href='".BASE_URL."admin/postsManagement'>Manage</a>
            </div>
            "
            : ""
        ?>

        <?= ($sessionManager->getSessionVariable("logged") === true) ?
            "
            <div class='svg-plus-text'>
                <img class='svg' src='".BASE_URL."public/svg/logout.svg'/>
                <a id='login' href='".BASE_URL."user/logout'>Logout</a>
            </div>
            " 
            : "
            <div class='svg-plus-text'>
                <img class='svg' src='".BASE_URL."public/svg/login.svg'/>
                <a id='login' href='".BASE_URL."user/login'". (isset($page) && $page == "loginUser" ? "style='font-weight:bold;'" : "") . ">Login</a>
            </div>
            ";
        ?>
    </div>
</div>
