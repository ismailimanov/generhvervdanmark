<?php
    include("inc/config.php");
?>
<!doctype html>
<html lang="da">
<head>
    <title>Generhverv Danmark</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Få kørekortet tilbage hos Generhverv Danmark"/>

    <link href="css/reset.css" type="text/css" rel="stylesheet">
    <link href="css/simplegrid.css" type="text/css" rel="stylesheet">
    <link href="css/main.css" type="text/css" rel="stylesheet">

    <script src="https://use.fontawesome.com/bca656bdb8.js"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/classie/1.0.1/classie.min.js"></script>
    <script src="js/script.js" type="text/javascript"></script>

    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:500,600,700" rel="stylesheet">
</head>
<body>
<div class="mobileMenu">
    <div class="mobileMenu--close" id="closeMenu"><i class="fa fa-times"></i></div>
    <div class="mobileMenu--item">Forside</div>
    <div class="mobileMenu--item">Om Os</div>
    <div class="mobileMenu--item">Kontakt Os</div>
    <div class="mobileMenu--item">Log Ind</div>
    <div class="mobileMenu--item">Tilmeld Dig</div>
</div>
<header>
    <div class="grid grid-pad">
        <div class="col-3-12 logoContainer">
            <div class="content">
                <a href="forside"><div class="logoContainer--logo"></div></a>
            </div>
        </div>
        <div class="col-9-12 menuContainer">
            <div class="content">
                <ul class="menuContainer--menu">
                    <li><a href="forside">Forside</a></li>
                    <li><a href="om-os">Om Os</a></li>
                    <li><a href="kontakt-os">Kontakt Os</a></li>
                    <?php
                    if(!isset($_SESSION["user_id"])) {
                        ?>
                        <li class="btn"><a href="log-ind">Log ind</a></li>
                        <li class="btn"><a href="tilmeld-dig">Tilmed dig</a></li>
                        <?php
                    } else {
                        ?>
                        <li class="btn"><a href="kontrolpanel">Kontrol Panel</a></li>
                    <?php
                    }
                    ?>
                </ul>
                <div class="menuContainer--mobilemenu" id="menuTrigger">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
        </div>
    </div>
</header>