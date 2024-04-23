<div class="footer">
    <div class="footer1">
        <div class="footer-contact">
            <?= (($sessionManager->getSessionVariable("logged") === true)  && ($sessionManager->getSessionVariable("userRole") === "admin")) ?
                "
                <div class='logo-network'>
                    <a href='".htmlspecialchars(BASE_URL)."admin/postsManagement'><img class='svg' src='".htmlspecialchars(BASE_URL)."public/svg/gear.svg'/><div class='navbar-text'>Manage</div></a>
                </div>
                "
                : ""
            ?>
            <div class="logo-network">
                <a href="<?= htmlspecialchars(BASE_URL) ?>public/cv/basile-pineau-cv.pdf" target="_blank"><img src="<?= htmlspecialchars(BASE_URL) ?>public/svg/download.svg"><div class='navbar-text'>My CV</div></a>
            </div>
            <div class='navbar-text' style="text-align:center">Contact : basile.pineau@greta-cfa-aquitaine.academy</div>
        </div>
        <div class="footer-network">
            <div class="logo-network">
                <a href="https://github.com/basile64" target="_blank"><img src="<?= htmlspecialchars(BASE_URL) ?>public/img/github.png"><div class="navbar-text">GitHub</div></a>
            </div>
            <div class="logo-network">
                <a href="http://instagram.com" target="_blank"><img src="<?= htmlspecialchars(BASE_URL) ?>public/img/instagram.png"><div class="navbar-text">Instagram</div></a>
            </div>
            <div class="logo-network">
                <a href="http://facebook.com" target="_blank"><img src="<?= htmlspecialchars(BASE_URL) ?>public/img/facebook.png"><div class="navbar-text">Facebook</div></a>
            </div>
        </div>
    </div>
    <div class="footer2 navbar-text">
        Basile PINEAU© - All rights reserved - 2024
    </div>
</div>