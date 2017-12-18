<?php
include("cp.header.php");
if(paymentStatus($link, $_SESSION["user_id"]) == false){
    messagebox("error", "Husk at du skal betale før du kan benytte de forskellige services som vi tilbyder.");
}

$getText = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM panelText WHERE id='1'"));
?>
    <h1>Velkommen <?=getFullName($link, $_SESSION["user_id"])?></h1>
<?=$getText["panelText"]?>
<?php
include("cp.footer.php");
?>