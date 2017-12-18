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
    $getUsertype = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id='{$user_id}'"));
    $getPaymentStatus = mysqli_query($link, "SELECT * FROM payment WHERE user_id='{$user_id}'");

    if (mysqli_num_rows($getPaymentStatus) > 0) {
        return true;
    } else {
        if($getUsertype["usertype"] == 1) {
            return false;
        } else {
            return true;
        }
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
            <td><img src="<?=$teacher["imageURL"]?>" alt="<?=$teacher["firstname"]?> <?=$teacher["lastname"]?>" class="teacherImage"></td>
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

function chatList($link, $teacher_id){
    $getChat = mysqli_query($link, "SELECT chat.id AS cid, chat.user_id AS cuid, chat.teacher_id AS ctid, users.id AS uid, users.firstname AS ufn, users.lastname AS uln, users.city AS uc, (SELECT COUNT(*) FROM chatMessage WHERE chatMessage.chat_id = chat.id) AS cma FROM chat JOIN users ON chat.user_id = users.id JOIN chatMessage ON chatMessage.chat_id = chat.id WHERE chat.teacher_id = '{$teacher_id}' GROUP BY cid ORDER BY cid DESC");

    while($chat = mysqli_fetch_array($getChat)){
        ?>
        <tr>
            <td><?=$chat["ufn"]?></td>
            <td><?=$chat["uln"]?></td>
            <td><?=$chat["uc"]?></td>
            <td><?=$chat["cma"]?></td>
            <td><a href="?cid=<?=$chat["cid"]?>"><i class="fa fa-comments"></i></a></td>
        </tr>
        <?php
    }
}

function getApplications($link, $teacher_id){
    $getApplications = mysqli_query($link, "SELECT teacherStudent.id AS tsid, teacherStudent.user_id AS uid, users.firstname AS ufn, users.lastname AS uln, users.city AS uc, users.phonenumber AS upn FROM teacherStudent JOIN users ON teacherStudent.user_id = users.id WHERE teacher_id='{$teacher_id}' AND accepted='0'");
    if(mysqli_num_rows($getApplications) > 0){
        while($application = mysqli_fetch_array($getApplications)){
            ?>
                <tr>
                    <td><?=$application["ufn"]?></td>
                    <td><?=$application["uln"]?></td>
                    <td><?=$application["uc"]?></td>
                    <td><?=$application["upn"]?></td>
                    <td><a href="accepter?id=<?=$application["tsid"]?>"><i class="fa fa-check accept" title="Accepter"></i></a> <a href="afvis?id=<?=$application["tsid"]?>"><i class="fa fa-times reject" title="Afvis"></i></a></td>
                </tr>
            <?php
        }
    } else {
        messagebox("error", "Ingen nye ansøgninger");
    }
}

function acceptStudent($link, $teacher_id, $id, $message){
    $checkStudent = mysqli_query($link, "SELECT * FROM teacherStudent WHERE teacher_id='{$teacher_id}' AND id='{$id}'");

    if(mysqli_num_rows($checkStudent) > 0){
        mysqli_query($link, "UPDATE teacherStudent SET accepted='1' WHERE teacher_id='{$teacher_id}' AND id='{$id}'");

        if(mysqli_affected_rows($link) > 0){
            $studentInfo = mysqli_fetch_assoc($checkStudent);
            mysqli_query($link, "INSERT INTO chat (user_id, teacher_id) VALUES ('{$studentInfo["user_id"]}', '{$teacher_id}')");

            if(mysqli_affected_rows($link) > 0){
                $getChatID = mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM chat WHERE teacher_id='{$teacher_id}' AND user_id='{$studentInfo["user_id"]}'"));
                mysqli_query($link, "INSERT INTO chatMessage (sender, receiver, message, chat_id) VALUES ('$teacher_id', '{$studentInfo["user_id"]}', '{$message}', '{$getChatID["id"]}')");

                if(mysqli_affected_rows($link) > 0){
                    messagebox("success", "Du har nu accepteret eleven.");
                } else {
                    messagebox("error", "Fejl under sendelse af besked.");
                }
            } else {
                messagebox("error", "Fejl under oprettelse af chat.");
            }
        } else {
            messagebox("error", "Fejl under accept af elev.");
        }
    } else {
        messagebox("error", "Dette er ikke en af dine elever.");
    }
}

function rejectStudent($link, $teacher_id, $id, $message){
    $checkStudent = mysqli_query($link, "SELECT * FROM teacherStudent WHERE teacher_id='{$teacher_id}' AND id='{$id}'");

    if(mysqli_num_rows($checkStudent) > 0){
        $studentInfo = mysqli_fetch_assoc($checkStudent);
        mysqli_query($link, "INSERT INTO chat (user_id, teacher_id) VALUES ('{$studentInfo["user_id"]}', '{$teacher_id}')");

        if(mysqli_affected_rows($link) > 0){
            $getChatID = mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM chat WHERE teacher_id='{$teacher_id}' AND user_id='{$studentInfo["user_id"]}'"));
            mysqli_query($link, "INSERT INTO chatMessage (sender, receiver, message, chat_id) VALUES ('$teacher_id', '{$studentInfo["user_id"]}', '{$message}', '{$getChatID["id"]}')");

            if(mysqli_affected_rows($link) > 0){
                messagebox("success", "Du har nu afvist eleven.");
            } else {
                messagebox("error", "Fejl under sendelse af besked.");
            }
        } else {
            messagebox("error", "Fejl under oprettelse af chat.");
        }
    } else {
        messagebox("error", "Dette er ikke en af dine elever.");
    }
}

function newTeacher($link, $user_id, $teacher_id, $chat_id){
    mysqli_query($link, "DELETE FROM chatMessage WHERE chat_id='{$chat_id}'");

    if(mysqli_affected_rows($link) > 0){
        mysqli_query($link, "DELETE FROM chat WHERE id='{$chat_id}'");

        if(mysqli_affected_rows($link) > 0){
            mysqli_query($link, "DELETE FROM teacherStudent WHERE user_id='{$user_id}'");

            if(mysqli_affected_rows($link) > 0){
                header("Location: kontrolpanel");
                exit();
            } else {
                messagebox("error", "Kunne ikke slette kørelærer. Prøv igen.");
            }
        } else {
            messagebox("error", "Kunne ikke slette chat. Prøv igen.");
        }
    } else {
        messagebox("error", "Kunne ikke slette beskeder. Prøv igen.");
    }
}

function checkTeacher($link, $user_id){
    $checkTeacher = mysqli_query($link, "SELECT * FROM teacherStudent WHERE user_id='{$user_id}'");

    if(mysqli_num_rows($checkTeacher) > 0){
        return true;
    } else {
        return false;
    }
}

function checkValidTeacher($link, $user_id){
    $checkValidTeacher = mysqli_query($link, "SELECT * FROM teacherStudent WHERE user_id='{$user_id}' AND accepted='1'");

    if(mysqli_num_rows($checkValidTeacher) > 0){
        return true;
    } else {
        return false;
    }
}

function checkChat($link, $user_id){
    $checkChat = mysqli_query($link, "SELECT * FROM chat WHERE user_id='{$user_id}'");

    if(mysqli_num_rows($checkChat) > 0){
        return true;
    } else {
        return false;
    }
}

function paymentSuccessful($link, $user_id, $uxtime, $merchantnumber, $tid, $tchecksum, $checksum, $orderid, $shopplatform, $amount, $split, $date, $cvc, $expmonth, $expyear, $tcardno, $time, $cardid, $currency){
    if(!empty($uxtime) && !empty($merchantnumber) && !empty($tid) && !empty($tchecksum) && !empty($checksum) && !empty($orderid) && !empty($shopplatform) && !empty($amount) && $split != "" && !empty($date) && !empty($expmonth) && !empty($expyear) && !empty($tcardno) && !empty($time) && !empty($cardid) && !empty($currency)){
        if($tchecksum == $checksum){
            if($shopplatform == "Generhverv-Danmark"){
                if($amount == "150000.00"){
                    mysqli_query($link, "INSERT INTO payment (user_id) VALUES ('{$user_id}')");
                    
                    if(mysqli_affected_rows($link) > 0){
                        $getPaymentID = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM payment WHERE user_id='{$user_id}'"));
                        $paymentID = $getPaymentID["id"];
                        mysqli_query($link, "INSERT INTO paymentInfo (payment_id, uxtime, MerchantNumber, tid, tchecksum, checksum, orderid, ShopPlatform, amount, split, `date`, cvc, expmonth, expyear, tcardno, `time`, cardid, currency) VALUES ('{$paymentID}', '{$uxtime}', '{$merchantnumber}', '{$tid}', '{$tchecksum}', '{$checksum}', '{$orderid}', '{$shopplatform}', '{$amount}', '{$split}', '{$date}', '{$cvc}', '{$expmonth}', '{$expyear}', '{$tcardno}', '{$time}', '{$cardid}', '{$currency}')");

                        if(mysqli_affected_rows($link) > 0){
                            header("Location: betaling?success");
                            exit();
                        } else {
                            messagebox("error", "Kunne ikke oprette betalings info i databasen. Kontakt os hvis du mener at dette er en fejl.");
                        }
                    } else {
                        messagebox("error", "Kunne ikke oprette betalingen i databasen. Kontakt os hvis du mener at dette er en fejl.");
                    }
                } else {
                    messagebox("error", "Det rigtige beløb er ikke blevet betalt. Kontakt os venligst hvis du mener at dette er en fejl.");
                }
            } else {
                messagebox("error", "Fejl i ShopPlatform. Kontakt os venligst hvis du mener at dette er en fejl.");
            }
        } else {
            messagebox("error", "Checksum matcher ikke. Kontakt os venligst hvis du mener at dette er en fejl.");
        }
    } else {
        messagebox("error", "Fejl i betalingsparameterne. Kontakt os venligst hvis du mener at dette er en fejl.");
    }
}

function changeImage($link, $user_id, $image, $imagetype, $imagefile){
    if($imagetype != "png" && $imagetype != "jpg" && $imagetype != "jpeg"){
        messagebox("error", "Billedetypen er ikke understøttet");
    } else {
        if(move_uploaded_file($imagefile["tmp_name"], $image)) {
            mysqli_query($link, "UPDATE users SET imageURL='{$image}' WHERE id='{$user_id}'");

            if(mysqli_affected_rows($link) > 0){
                messagebox("success", "Dit billede er nu ændret.");
            } else {
                messagebox("error", "Dit billede kunne ikke ændres.");
            }
        }
    }
}

function teachers($link){
    $getTeachers = mysqli_query($link, "SELECT * FROM users WHERE usertype='2' ORDER BY rand()");
    while($teacher = mysqli_fetch_array($getTeachers)){
        ?>
        <tr>
            <td><img src="<?=$teacher["imageURL"]?>" alt="<?=$teacher["firstname"]?> <?=$teacher["lastname"]?>" class="teacherImage"></td>
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
            <td>
                <a href="rediger-kørelærer?id=<?=$teacher["id"]?>"><i class="fa fa-pencil"></i></a>
                <a href="?delete=<?=$teacher["id"]?>" onclick="return confirm('Er du sikker på at du vil slette kørelæreren?')"><i class="fa fa-times"></i></a>
            </td>
        </tr>
        <?php
    }
}

function createTeacher($link, $firstname, $lastname, $phonenumber, $address, $zipcode, $city, $email, $username, $password, $image, $imagetype, $imagefile){
    $checkUsername = mysqli_query($link, "SELECT * FROM users WHERE username='{$username}'");
    $password = password_hash($password, PASSWORD_DEFAULT);

    if(mysqli_num_rows($checkUsername) > 0){
        messagebox("error", "Brugernavnet er optaget.");
    } else {
        $checkEmail = mysqli_query($link, "SELECT * FROM users WHERE email='{$email}'");

        if(mysqli_num_rows($checkEmail) > 0){
            messagebox("error", "E-mail adressen er optaget.");
        } else {
            if(!empty($imagefile["name"])){
                if($imagetype != "png" && $imagetype != "jpg" && $imagetype != "jpeg"){
                    messagebox("error", "Billedetypen er ikke understøttet");
                } else {
                    if(move_uploaded_file($imagefile["tmp_name"], $image)) {
                        mysqli_query($link, "INSERT INTO users (firstname, lastname, phonenumber, address, zipcode, city, email, username, password, usertype, imageURL) VALUES ('{$firstname}', '{$lastname}', '{$phonenumber}', '{$address}', '{$zipcode}', '{$city}', '{$email}', '{$username}', '{$password}', '2', '{$image}')");

                        if(mysqli_affected_rows($link) > 0){
                            messagebox("success", "Kørelæreren er nu tilføjet.");
                        } else {
                            messagebox("error", "Kørelæreren kunne ikke tilføjes.");
                        }
                    } else {
                        messagebox("error", "Billedet kunne ikke uploades.");
                    }
                }
            } else {
                mysqli_query($link, "INSERT INTO users (firstname, lastname, phonenumber, address, zipcode, city, email, username, password, usertype) VALUES ('{$firstname}', '{$lastname}', '{$phonenumber}', '{$address}', '{$zipcode}', '{$city}', '{$email}', '{$username}', '{$password}', '2')");

                if(mysqli_affected_rows($link) > 0){
                    messagebox("success", "Kørelæreren er nu tilføjet.");
                } else {
                    messagebox("error", "Kørelæreren kunne ikke tilføjes.");
                }
            }
        }
    }
}

function deleteTeacher($link, $teacher_id){
    $checkTeacher = mysqli_query($link, "SELECT * FROM users WHERE id='{$teacher_id}' AND usertype='2'");

    if(mysqli_num_rows($checkTeacher) > 0){
        $getChatIDs = mysqli_query($link, "SELECT * FROM chat WHERE teacher_id='{$teacher_id}'");

        while($ids = mysqli_fetch_array($getChatIDs)){
            mysqli_query($link, "DELETE FROM chatMessage WHERE chat_id='{$ids["id"]}'");
        }

        $deleteChat = mysqli_query($link, "DELETE FROM chat WHERE teacher_id='{$teacher_id}'");
        if($deleteChat){
            $deleteRating = mysqli_query($link, "DELETE FROM teacherRating WHERE teacher_id='{$teacher_id}'");

            if($deleteRating){
                $deleteTeacherStudent = mysqli_query($link, "DELETE FROM teacherStudent WHERE teacher_id='{$teacher_id}'");

                if($deleteTeacherStudent){
                    $deleteTeacher = mysqli_query($link, "DELETE FROM users WHERE id='{$teacher_id}' AND usertype='2'");

                    if($deleteTeacher){
                        messagebox("success", "Kørelæreren er nu slettet.");
                    } else {
                        messagebox("error", "Kunne ikke slette lærerens bruger.");
                    }
                } else {
                    messagebox("error", "Kunne ikke slette lærer-elev relation.");
                }
            } else {
                messagebox("error", "Kunne ikke slette lærerens vurderinger.");
            }
        } else {
            messagebox("error", "Kunne ikke slette kørelærerens chat.");
        }
    } else {
        messagebox("error", "Der findes ikke en kørelærer med dette id");
    }
}

function editTeacher($link, $teacher_id, $firstname, $lastname, $phonenumber, $address, $zipcode, $city){
    mysqli_query($link, "UPDATE users SET firstname='{$firstname}', lastname='{$lastname}', phonenumber='{$phonenumber}', address='{$address}', zipcode='{$zipcode}', city='{$city}' WHERE id='{$teacher_id}'");
    if(mysqli_affected_rows($link) > 0){
        messagebox("success", "Oplysninger er nu ændret.");
    } else {
        messagebox("error", "Oplysninger kunne ikke ændres.");
    }
}

function students($link){
    $getStudents = mysqli_query($link, "SELECT * FROM users WHERE usertype='1' ORDER BY id DESC");
    while($student = mysqli_fetch_array($getStudents)){
        ?>
        <tr>
            <td><?=$student["firstname"]?></td>
            <td><?=$student["lastname"]?></td>
            <td><?=$student["city"]?></td>
            <td><?=$student["phonenumber"]?></td>
            <td>
                <a href="?delete=<?=$student["id"]?>" onclick="return confirm('Er du sikker på at du vil slette eleven?')"><i class="fa fa-times"></i></a>
            </td>
        </tr>
        <?php
    }
}

function deleteStudent($link, $user_id){
    $checkStudent = mysqli_query($link, "SELECT * FROM users WHERE id='{$user_id}' AND usertype='1'");

    if(mysqli_num_rows($checkStudent) > 0){
        $getChatIDs = mysqli_query($link, "SELECT * FROM chat WHERE user_id='{$user_id}'");

        while($ids = mysqli_fetch_array($getChatIDs)){
            mysqli_query($link, "DELETE FROM chatMessage WHERE chat_id='{$ids["id"]}'");
        }

        $deleteChat = mysqli_query($link, "DELETE FROM chat WHERE user_id='{$user_id}'");
        if($deleteChat){
            $deleteReview = mysqli_query($link, "DELETE FROM reviews WHERE user_id='{$user_id}'");

            if($deleteReview){
                $deleteTeacherStudent = mysqli_query($link, "DELETE FROM teacherStudent WHERE user_id='{$user_id}'");

                if($deleteTeacherStudent){
                    $getPaymentID = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM payment WHERE user_id='{$user_id}'"));
                    $deletePaymentInfo = mysqli_query($link, "DELETE FROM paymentInfo WHERE payment_id='{$getPaymentID["id"]}'");

                    if($deletePaymentInfo){
                        $deletePayment = mysqli_query($link, "DELETE FROM payment WHERE user_id='{$user_id}'");

                        if($deletePayment){
                            $deleteStudent = mysqli_query($link, "DELETE FROM users WHERE id='{$user_id}' AND usertype='1'");

                            if($deleteStudent){
                                messagebox("success", "Eleven er nu slettet.");
                            } else {
                                messagebox("error", "Kunne ikke slette elevens bruger.");
                            }
                        } else {
                            messagebox("error", "Kunne ikke slette betaling.");
                        }
                    } else {
                        messagebox("error", "Kunne ikke slette betalingsoplysninger.");
                    }
                } else {
                    messagebox("error", "Kunne ikke slette elev-lærer relation.");
                }
            } else {
                messagebox("error", "Kunne ikke slette elevens vurderinger.");
            }
        } else {
            messagebox("error", "Kunne ikke slette elevens chat.");
        }
    } else {
        messagebox("error", "Der findes ikke en elev med dette id");
    }
}