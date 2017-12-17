<?php
include("cp.header.php");
$userType = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id='{$_SESSION["user_id"]}'"));

if(isset($_POST["write"])){
    $message  = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING) or messagebox("error", "Invalid besked");
    $receiver = filter_input(INPUT_POST, 'receiver', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid modtager id");
    $chatid   = filter_input(INPUT_POST, 'chat_id', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid chat id");

    writeChat($link, $_SESSION["user_id"], $receiver, $message, $userType["usertype"], $chatid);
}

if($userType["usertype"] == 1){
    $getChatID = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM chat WHERE user_id='{$_SESSION["user_id"]}'"));
} else {
    $getChatID = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM chat WHERE teacher_id='{$_SESSION["user_id"]}'"));
}
?>
<h1>Chat</h1>
<span class="breadcrumbs">Kørelærer &raquo; Chat</span>
<div class="content">
    <form action="<?=$_SERVER["PHP_SELF"]?>" method="post" class="chatForm">
        <textarea name="message" placeholder="Besked" required></textarea>
        <input type="hidden" name="chat_id" id="chatid" value="<?=$getChatID["id"]?>">
        <?php
        if($userType["usertype"] == 1){
            ?>
            <input type="hidden" name="receiver" id="receiver" value="<?=$getChatID["teacher_id"]?>">
            <?php
        } else {
            ?>
            <input type="hidden" name="receiver" id="receiver" value="<?=$getChatID["user_id"]?>">
            <?php
        }
        ?>
        <?php

        ?>
        <input type="submit" name="write" value="Skriv">
    </form>
    <div class="divider"></div>
    <div class="chatBoxes"></div>
</div>
<?php
include("cp.footer.php");
?>