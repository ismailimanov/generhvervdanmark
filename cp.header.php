<?php
include("inc/config.php");
if(!isset($_SESSION["user_id"])){
    header("Location: log-ind");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Generhverv Danmark - Kontrol Panel</title>
    <link href="css/controlpanel.css" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700" type="text/css" rel="stylesheet">
    <script src="https://use.fontawesome.com/bca656bdb8.js"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/controlpanel.js"></script>
</head>
<body>
<div class="panelContainer">
    <div class="panelContainer--sidebar">
        <div class="panelContainer--sidebar--logo"></div>
        <div class="panelContainer--sidebar--menu">
            <i class="fa fa-home"></i> Forside
        </div>
        <div class="panelContainer--sidebar--menu">
            <i class="fa fa-credit-card"></i> Betaling
        </div>
        <div class="panelContainer--sidebar--menu<?php if(paymentStatus($link, $_SESSION["user_id"]) == false){ echo " disabled";}?>" <?php if(paymentStatus($link, $_SESSION["user_id"]) == true){ echo 'id="teacherDropdownButton"';}?>>
            <i class="fa fa-user-circle-o"></i> Kørelærer
        </div>
        <div class="panelContainer--sidebar--dropdown" id="teacherDropdown">
            <div class="panelContainer--sidebar--dropdown--menu">
                <i class="fa fa-user-plus"></i> Vælg kørelærer
            </div>
            <div class="panelContainer--sidebar--dropdown--menu">
                <i class="fa fa-user"></i> Anmeld kørelærer
            </div>
            <div class="panelContainer--sidebar--dropdown--menu">
                <i class="fa fa-comments-o"></i> Chat
            </div>
        </div>
        <div class="panelContainer--sidebar--menu<?php if(paymentStatus($link, $_SESSION["user_id"]) == false){ echo " disabled";}?>">
            <i class="fa fa-star-o"></i> Skriv anmeldelse
        </div>
        <div class="panelContainer--sidebar--menu" id="settingsDropdownButton">
            <i class="fa fa-cog"></i> Indstillinger
        </div>
        <div class="panelContainer--sidebar--dropdown" id="settingsDropdown">
            <div class="panelContainer--sidebar--dropdown--menu">
                <i class="fa fa-user"></i> Brugeroplysninger
            </div>
            <div class="panelContainer--sidebar--dropdown--menu">
                <i class="fa fa-key"></i> Skift kodeord
            </div>
        </div>
        <div class="panelContainer--sidebar--menu" onclick="location.href='log-ud';">
            <i class="fa fa-sign-out"></i> Log ud
        </div>
    </div>
    <div class="panelContainer--content">
        <div class="panelContainer--content--container">