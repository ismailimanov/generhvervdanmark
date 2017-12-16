<?php
include("cp.header.php");

if(isset($_POST["update"])){
    $password      = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) or messagebox("error", "Ugyldig fornavn");
    $newpassword   = filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig efternavn");

    updatePassword($link, $_SESSION["user_id"], $password, $newpassword);
}
?>
<h1>Skift kodeord</h1>
<span class="breadcrumbs">Indstillinger &raquo; Skift kodeord</span>
<div class="content">
    <form action="<?=$_SERVER["PHP_SELF"]?>" method="post">
        <input type="password" name="password" placeholder="Nuværende kodeord">
        <input type="password" name="newpassword" placeholder="Ny kodeord">
        <input type="submit" name="update" value="Opdater">
    </form>
</div>
<?php
include("cp.footer.php");
?>
