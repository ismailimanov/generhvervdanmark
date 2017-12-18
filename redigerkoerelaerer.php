<?php
include("cp.header.php");

if(isset($_POST["edit"])){
    $firstname      = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING) or messagebox("error", "Ugyldig fornavn");
    $lastname       = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig efternavn");
    $phonenumber    = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_NUMBER_INT) or messagebox("error","Ugyldig telefonnummer");
    $address        = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig adresse");
    $zipcode        = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_NUMBER_INT) or messagebox("error","Ugyldig postnummer");
    $city           = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig by");

    $id = $_GET["id"];

    editTeacher($link, $id, $firstname, $lastname, $phonenumber, $address, $zipcode, $city);
}

$getInfo = mysqli_query($link, "SELECT * FROM users WHERE id='{$_GET["id"]}'");
$info = mysqli_fetch_assoc($getInfo);
?>
    <h1>Rediger kørelærer</h1>
    <span class="breadcrumbs">Admin &raquo; Kørelærer &raquo; Rediger kørelærer</span>
    <div class="content">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="firstname" placeholder="Fornavn" value="<?=$info["firstname"]?>" required>
            <input type="text" name="lastname" placeholder="Efternavn" value="<?=$info["lastname"]?>" required>
            <input type="tel" name="phonenumber" placeholder="Telefonnummer" value="<?=$info["phonenumber"]?>" required>
            <input type="text" name="address" placeholder="Adresse" value="<?=$info["address"]?>" required>
            <input type="number" name="zipcode" placeholder="Postnummer" value="<?=$info["zipcode"]?>" required>
            <input type="text" name="city" placeholder="By" value="<?=$info["city"]?>" required>

            <input type="submit" name="edit" value="Rediger Kørelærer">
        </form>
    </div>
<?php
include("cp.footer.php");
?>