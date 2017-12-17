<?php
include("cp.header.php");
if(paymentStatus($link, $_SESSION["user_id"]) == false){
    messagebox("error", "Husk at du skal betale før du kan benytte de forskellige services som vi tilbyder.");
}
?>
    <h1>Velkommen <?=getFullName($link, $_SESSION["user_id"])?></h1>
<?php
include("cp.footer.php");
?>