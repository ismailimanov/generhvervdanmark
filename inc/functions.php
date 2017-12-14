<?php
function message($message){
    echo '<script>javascript:alert("' . $message . '");</script>';
}

function createUser($link, $firstname, $lastname, $phonenumber, $address, $zipcode, $city, $email, $username, $password){
    $username   = strtolower($username);
    $email      = strtolower($email);
    $password   = password_hash($password, PASSWORD_DEFAULT);
    // Error handling
    if(!is_numeric($zipcode)){
        message("Postnummer skal være et nummer");
    } elseif(!is_numeric($phonenumber)){
        message("Telefonnummer skal være et nummer");
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        message("Ugyldig e-mail adresse");
    } else {
        $checkEmail = mysqli_query($link, "SELECT * FROM users WHERE email='{$email}'");
        $checkUsername = mysqli_query($link, "SELECT * FROM users WHERE username='{$username}'");

        if(mysqli_num_rows($checkEmail) > 0){
            message("E-mail adressen findes allerede");
        } elseif(mysqli_num_rows($checkUsername) > 0){
            message("Brugernavnet er allerede taget");
        } else {
            mysqli_query($link, "INSERT INTO users (firstname, lastname, phonenumber, address, zipcode, city, email, username, password) VALUES ('{$firstname}', '{$lastname}', '{$phonenumber}', '{$address}', '{$zipcode}', '{$city}', '{$email}', '{$username}', '{$password}')");
            message("Din bruger er nu oprettet");
        }
    }
}

function login($link, $username, $password){
    $username   = strtolower($username);

    $getData = mysqli_query($link, "SELECT * FROM users WHERE username='{$username}'");

    if(mysqli_num_rows($getData) > 0){
        $data = mysqli_fetch_assoc($getData);
        if(password_verify($password, $data["password"])){
            $_SESSION["user_id"] = $data["id"];
            header("Location: kontrol-panel");
            exit();
        } else {
            message("Forkert kodeord");
        }
    } else {
        message("Brugeren findes ikke");
    }
}