<?php
include("inc/config.php");

if(isset($_SESSION["user_id"])){
    header("Location: kontrol-panel");
    exit();
}wa

if(isset($_GET["create"])){
    $firstname      = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING) or die("Invalid first name");
    $lastname       = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING) or die("Invalid last name");
    $phonenumber    = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_STRING) or die("Invalid phone number");
    $address        = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING) or die("Invalid address");
    $zipcode        = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING) or die("Invalid zip code");
    $city           = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING) or die("Invalid city");
    $email          = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING) or die("Invalid email address");
    $username       = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) or die("Invalid username");
    $password       = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) or die("Invalid password");

    createUser($link, $firstname, $lastname, $phonenumber, $address, $zipcode, $city, $email, $username, $password);
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="css/controlpanel.css" type="text/css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300" type="text/css" rel="stylesheet">
        <title>Generhverv Danmark - Tilmeld dig</title>
    </head>
    <body class="form">
        <div class="formContainer">
            <div class="formContainer--content">
                <h1>Generhverv Danmark</h1>

                <form class="formContainer--content--form" action="?create" method="post">
                    <?php
                        if(isset($error)){
                            echo $error;
                        }
                    ?>
                    <input type="text" name="firstname" placeholder="Fornavn" required>
                    <input type="text" name="lastname" placeholder="Efternavn" required>
                    <input type="tel" name="phonenumber" placeholder="Telefonnummer" required>
                    <input type="text" name="address" placeholder="Adresse" required>
                    <input type="number" name="zipcode" placeholder="Postnummer" required>
                    <input type="text" name="city" placeholder="By" required>
                    <input type="email" name="email" placeholder="E-mail adresse" required>
                    <input type="text" name="username" placeholder="Brugernavn" required>
                    <input type="password" name="password" placeholder="Kodeord" required>
                    <button type="submit" name="logind">Tilmeld dig</button>
                    <span>Har du allerede en bruger? <a href="log-ind"><b>Log ind</b></a></span>
                </form>
            </div>

            <ul class="squareContainer">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </body>
</html>