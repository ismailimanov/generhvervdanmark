<?php
include("inc/config.php");
$userType = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id='{$_SESSION["user_id"]}'"));
$chatid = filter_input(INPUT_POST, 'chatid', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Ugyldig chat id");
$receiver = filter_input(INPUT_POST, 'receiver', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Ugyldig chat id");

if($userType["usertype"] == 1){
    $checkChat = mysqli_query($link, "SELECT * FROM chat WHERE user_id='{$_SESSION["user_id"]}' AND teacher_id='{$receiver}'");
    if(mysqli_num_rows($checkChat) != 1){
        die();
    }
} else {
    $checkChat = mysqli_query($link, "SELECT * FROM chat WHERE user_id='{$receiver}' AND teacher_id='{$_SESSION["user_id"]}'");
    if(mysqli_num_rows($checkChat) != 1){
        die();
    }
}

$getChat = mysqli_query($link, "SELECT chatMessage.sender, chatMessage.receiver, chatMessage.message, chatMessage.date, users.firstname AS firstname, users.lastname AS lastname FROM chatMessage JOIN users ON chatMessage.sender = users.id WHERE chat_id='{$chatid}' ORDER BY chatMessage.id DESC");
while($chat = mysqli_fetch_array($getChat)){
    $danishDate = date("H:i:s d-m-Y", strtotime($chat["date"]));
    ?>
    <div class="chatBox <?php if($chat["sender"] == $_SESSION["user_id"]){ echo "cRight"; } else { echo "cLeft"; } ?>">
        <span><?=$chat["message"]?></span>
        <?php
            if($chat["sender"] == $_SESSION["user_id"]) {
                ?>
                <span class="chatBox--info"><?= $danishDate ?> - <?= $chat["firstname"] ?> <?= $chat["lastname"] ?></span>
                <?php
            } else {
                ?>
                <span class="chatBox--info"><?= $chat["firstname"] ?> <?= $chat["lastname"] ?> - <?= $danishDate ?></span>
                <?php
            }
        ?>
    </div>
<?php
}
?>