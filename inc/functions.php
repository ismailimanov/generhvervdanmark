<?php
function message($message){
    echo '<script>javascript:alert("' . $message . '");</script>';
}

function messagebox($style, $message){
    if($style == "error"){
        ?>
        <div class="message error"><?=$message?></div>
        <?php
    } else {
        ?>
        <div class="message success"><?=$message?></div>
        <?php
    }
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
            header("Location: kontrolpanel");
            exit();
        } else {
            message("Forkert kodeord");
        }
    } else {
        message("Brugeren findes ikke");
    }
}

function paymentStatus($link, $user_id){
    $getPaymentStatus = mysqli_query($link, "SELECT * FROM payment WHERE user_id='{$user_id}'");

    if(mysqli_num_rows($getPaymentStatus) > 0){
        return true;
    } else {
        return false;
    }
}

function getFullName($link, $user_id){
    $getInfo = mysqli_query($link, "SELECT firstname, lastname FROM users WHERE id='{$user_id}'");
    $info = mysqli_fetch_assoc($getInfo);
    return $info['firstname'] . " " . $info['lastname'];
}

function updateInfo($link, $user_id, $firstname, $lastname, $phonenumber, $address, $zipcode, $city){
    mysqli_query($link, "UPDATE users SET firstname='{$firstname}', lastname='{$lastname}', phonenumber='{$phonenumber}', address='{$address}', zipcode='{$zipcode}', city='{$city}' WHERE id='{$user_id}'");
    if(mysqli_affected_rows($link) > 0){
        messagebox("success", "Dine oplysninger er nu ændret");
    } else {
        messagebox("error", "Dine oplysninger kunne ikke ændres");
    }
}

function updatePassword($link, $user_id, $password, $newpassword){
    $getPassword = mysqli_query($link, "SELECT password FROM users WHERE id='{$user_id}'");
    $currentPassword = mysqli_fetch_assoc($getPassword);

    if(password_verify($password, $currentPassword["password"])){
        $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
        mysqli_query($link, "UPDATE users SET password='{$newpassword}' WHERE id='{$user_id}'");
        
        if(mysqli_affected_rows($link) > 0){
            messagebox("success", "Dit kodeord er nu opdateret");
        } else {
            messagebox("error", "Dit kodeord kunne ikke opdateres");
        }
    } else {
        messagebox("error", "Dit nuværende kodeord var ikke korrekt");
    }
}