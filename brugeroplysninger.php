<?php
include("cp.header.php");

if(isset($_POST["update"])){
    $firstname      = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING) or messagebox("error", "Ugyldig fornavn");
    $lastname       = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig efternavn");
    $phonenumber    = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig telefonnummer");
    $address        = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig adresse");
    $zipcode        = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig postnummer");
    $city           = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig by");

    updateInfo($link, $_SESSION["user_id"], $firstname, $lastname, $phonenumber, $address, $zipcode, $city);
}

$getInfo = mysqli_query($link, "SELECT * FROM users WHERE id='{$_SESSION["user_id"]}'");
$info = mysqli_fetch_assoc($getInfo);
?>
<h1>Brugeroplysninger</h1>
<span class="breadcrumbs">Indstillinger &raquo; Brugeroplysninger</span>
<div class="content">
    <form action="" method="post">
        <input type="text" name="firstname" placeholder="Fornavn" value="<?=$info["firstname"]?>" required>
        <input type="text" name="lastname" placeholder="Efternavn" value="<?=$info["lastname"]?>" required>
        <input type="text" name="phonenumber" placeholder="Telefonnummer" value="<?=$info["phonenumber"]?>" required>
        <input type="text" name="address" placeholder="Adresse" value="<?=$info["address"]?>" required>
        <input type="text" name="zipcode" placeholder="Postnummer" value="<?=$info["zipcode"]?>" required>
        <input type="text" name="city" placeholder="By" value="<?=$info["city"]?>" required>
        <input type="submit" name="update" value="Opdater">
    </form>
</div>
<?php
include("cp.footer.php");
?>