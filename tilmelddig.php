<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/controlpanel.css" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300" type="text/css" rel="stylesheet">
    <title>Generhverv Danmark - Kontrolpanel</title>
</head>
<body>
<div class="formContainer">
    <div class="formContainer--content">
        <h1>Generhverv Danmark</h1>

        <form class="formContainer--content--form" action="?login" method="post">
            <input type="text" name="firstname" placeholder="Fornavn" required>
            <input type="text" name="lastname" placeholder="Efternavn" required>
            <input type="tel" name="phonenumber" placeholder="Telefonnummer" required>
            <input type="text" name="address" placeholder="Adresse" required>
            <input type="number" maxlength="4" name="zipcode" placeholder="Postnummer" required>
            <input type="text" name="city" placeholder="By" required>
            <input type="email" name="email" placeholder="E-mail adresse" required>
            <input type="text" name="username" placeholder="Brugernavn" required>
            <input type="password" name="password" placeholder="Kodeord" required>
            <div class="squaredThree">
                <input type="checkbox" value="None" id="squaredThree" name="check" checked />
                <label for="squaredThree">asd</label>
            </div>
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