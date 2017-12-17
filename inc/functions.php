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

function checkUserType($link, $user_id){
    $checkUserType = mysqli_fetch_assoc(mysqli_query($link, "SELECT usertype FROM users WHERE id='{$user_id}'"));
    return $checkUserType["usertype"];
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
        messagebox("success", "Dine oplysninger er nu ændret.");
    } else {
        messagebox("error", "Dine oplysninger kunne ikke ændres.");
    }
}

function updatePassword($link, $user_id, $password, $newpassword){
    $getPassword = mysqli_query($link, "SELECT password FROM users WHERE id='{$user_id}'");
    $currentPassword = mysqli_fetch_assoc($getPassword);

    if(password_verify($password, $currentPassword["password"])){
        $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
        mysqli_query($link, "UPDATE users SET password='{$newpassword}' WHERE id='{$user_id}'");

        if(mysqli_affected_rows($link) > 0){
            messagebox("success", "Dit kodeord er nu opdateret.");
        } else {
            messagebox("error", "Dit kodeord kunne ikke opdateres.");
        }
    } else {
        messagebox("error", "Dit nuværende kodeord var ikke korrekt.");
    }
}

function writeReview($link, $user_id, $review){
    $check = mysqli_query($link, "SELECT * FROM reviews WHERE user_id='{$user_id}'");

    if(mysqli_num_rows($check) > 0){
        messagebox("error", "Du har allerede skrevet en anmeldelse.");
    } else {
        mysqli_query($link, "INSERT INTO reviews (user_id, review) VALUES ('{$user_id}', '{$review}')");
        if(mysqli_affected_rows($link) > 0){
            messagebox("success", "Tak! Din anmeldelse er nu sendt ind.");
        } else {
            messagebox("error", "Din anmeldelse kunne ikke sendes ind.");
        }
    }
}

function teacherList($link){
    $getTeachers = mysqli_query($link, "SELECT * FROM users WHERE usertype='2' ORDER BY rand()");
    while($teacher = mysqli_fetch_array($getTeachers)){
        ?>
            <tr>
                <td><?=$teacher["firstname"]?></td>
                <td><?=$teacher["lastname"]?></td>
                <td><?=$teacher["city"]?></td>
                <td>
                    <?php
                        $getRating = mysqli_fetch_assoc(mysqli_query($link, "SELECT AVG(rating) AS rating FROM teacherRating WHERE teacher_id='{$teacher["id"]}'"));
                        if(is_null($getRating["rating"])){
                            echo "Ingen vurdering";
                        } else {
                            echo $getRating["rating"];
                        }
                    ?>
                </td>
                <td><a href="?teacherid=<?=$teacher["id"]?>"><i class="fa fa-check-square-o"></i></a></td>
            </tr>
        <?php
    }
}

function selectTeacher($link, $user_id, $teacher_id){
    $checkTeacher = mysqli_query($link, "SELECT * FROM teacherStudent WHERE user_id='{$user_id}'");

    if(mysqli_num_rows($checkTeacher) > 0){
        messagebox("error", "Du har allerede sendt en ansøgning til en kørelærer.");
    } else {
        mysqli_query($link, "INSERT INTO teacherStudent (user_id, teacher_id) VALUES ('{$user_id}', '{$teacher_id}')");
        if(mysqli_affected_rows($link) > 0){
            messagebox("success", "Din ansøgning er nu sendt. Du vil få et svar hurtigst muligt.");
        } else {
            messagebox("error", "Der var en fejl under ansøgningen. Prøv venligst igen.");
        }
    }
}

function rateTeacher($link, $user_id, $teacher_id, $rating){
    $checkVote = mysqli_query($link, "SELECT * FROM teacherRating WHERE user_id='{$user_id}' AND teacher_id='{$teacher_id}'");

    if(mysqli_num_rows($checkVote) > 0){
        messagebox("error", "Du har allerede stemt!");
    } else {
        mysqli_query($link, "INSERT INTO teacherRating (teacher_id, rating, user_id) VALUES ('{$teacher_id}', '{$rating}', '{$user_id}')");
        if(mysqli_affected_rows($link) > 0){
            messagebox("success", "Tak for din vurdering!");
        } else {
            messagebox("error", "Din vurdering kunne ikke gemmes. Prøv venligst igen.");
        }
    }
}

function writeChat($link, $sender, $receiver, $message, $usertype, $chatid){
    if(!is_numeric($receiver) OR !is_numeric($sender)){
        messagebox("error", "Invalid sender eller modtager id");
    } else {
        if($usertype == 1){
            $checkChat = mysqli_query($link, "SELECT * FROM chat WHERE user_id='{$sender}' AND teacher_id='{$receiver}'");
            if(mysqli_num_rows($checkChat) > 0){
                mysqli_query($link, "INSERT INTO chatMessage (sender, receiver, message, chat_id) VALUES ('{$sender}', '{$receiver}', '{$message}', '{$chatid}')");
                if(mysqli_affected_rows($link) != 1){
                    messagebox("error", "Beskeden kunne ikke sendes. Prøv igen.");
                }
            } else {
                messagebox("error", "Du kan ikke sende en besked til denne bruger");
            }
        } else {
            $checkChat = mysqli_query($link, "SELECT * FROM chat WHERE user_id='{$receiver}' AND teacher_id='{$sender}'");
            if(mysqli_num_rows($checkChat) > 0){
                mysqli_query($link, "INSERT INTO chatMessage (sender, receiver, message, chat_id) VALUES ('{$sender}', '{$receiver}', '{$message}', '{$chatid}')");
                if(mysqli_affected_rows($link) != 1){
                    messagebox("error", "Beskeden kunne ikke sendes. Prøv igen.");
                }
            } else {
                messagebox("error", "Du kan ikke sende en besked til denne bruger");
            }
        }
    }
}