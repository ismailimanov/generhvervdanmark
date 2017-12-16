<?php
include("inc/config.php");
if(isset($_SESSION["user_id"])){
    header("Location: kontrolpanel");
    exit();
}
if(isset($_GET["login"])){
    $username       = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) or die("Invalid username");
    $password       = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) or die("Invalid password");

    login($link, $username, $password);
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="css/controlpanel.css" type="text/css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300" type="text/css" rel="stylesheet">
        <title>Generhverv Danmark - Log ind</title>
    </head>
    <body class="form">
        <div class="formContainer">
            <div class="formContainer--content">
                <h1>Generhverv Danmark</h1>

                <form class="formContainer--content--form" action="?login" method="post">
                    <input type="text" name="username" placeholder="Brugernavn">
                    <input type="password" name="password" placeholder="Kodeord">
                    <button type="submit" name="logind">Log ind</button>
                    <span>Har du ikke en bruger? <a href="tilmeld-dig"><b>Tilmed dig</b></a></span>
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