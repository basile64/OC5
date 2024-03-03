<?php

ob_start();

?>

<?php require_once("../src/views/post/postsView.php");?>


<?php

$content = ob_get_clean();

require_once("../src/views/layout.php");