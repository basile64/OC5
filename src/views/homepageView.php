<?php

ob_start();

$page = "home";

?>

<?php require_once("../src/views/post/postsView.php");?>


<?php

$content = ob_get_clean();

require_once("../src/views/mainLayout.php");