<?php

ob_start();

$page = "profileUser";

?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/user-profile.css">

<div class="posts-header">

</div>

<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");