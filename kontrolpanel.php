<?php
include("cp.header.php");
?>
    <h1>Velkommen <?=getFullName($link, $_SESSION["user_id"])?></h1>
<?php
include("cp.footer.php");
?>