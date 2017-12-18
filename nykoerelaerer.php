<?php
include("cp.header.php");

if(isset($_POST["create"])){
    $firstname      = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING) or messagebox("error", "Ugyldig fornavn");
    $lastname       = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig efternavn");
    $phonenumber    = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_NUMBER_INT) or messagebox("error","Ugyldig telefonnummer");
    $address        = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig adresse");
    $zipcode        = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_NUMBER_INT) or messagebox("error","Ugyldig postnummer");
    $city           = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig by");
    $email          = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig e-mail");
    $username       = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig brugernavn");
    $password       = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) or messagebox("error","Ugyldig kodeord");

    $folderName   = "uploads/";
    $time         = round(microtime(true) * 1000);
    $image        = $folderName . $time . "-" . basename($_FILES["image"]["name"]);
    $imageType    = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $imageFile    = $_FILES["image"];

    createTeacher($link, $firstname, $lastname, $phonenumber, $address, $zipcode, $city, $email, $username, $password, $image, $imageType, $imageFile);
}

?>
    <h1>Ny kørelærer</h1>
    <span class="breadcrumbs">Admin &raquo; Kørelærer &raquo; Ny kørelærer</span>
    <div class="content">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="firstname" placeholder="Fornavn" required>
            <input type="text" name="lastname" placeholder="Efternavn" required>
            <input type="tel" name="phonenumber" placeholder="Telefonnummer" required>
            <input type="text" name="address" placeholder="Adresse" required>
            <input type="number" name="zipcode" placeholder="Postnummer" required>
            <input type="text" name="city" placeholder="By" required>
            <input type="email" name="email" placeholder="E-mail adresse" required>
            <input type="text" name="username" placeholder="Brugernavn" required>
            <input type="password" name="password" placeholder="Kodeord" required>
            <input type="file" name="image">
            <input type="submit" name="create" value="Tilføj Kørelærer">
        </form>
    </div>
<?php
include("cp.footer.php");
?>