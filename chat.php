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

if(isset($_POST["new"])){
    $receiver = filter_input(INPUT_POST, 'receiver', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid modtager id");
    $chatid   = filter_input(INPUT_POST, 'chat_id', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid chat id");

    newTeacher($link, $_SESSION["user_id"], $receiver, $chatid);
}

if(checkUserType($link, $_SESSION["user_id"]) == 1) {
    $checkRejected = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM teacherStudent WHERE user_id='{$_SESSION["user_id"]}'"));
    ?>
    <h1>Chat</h1>
    <span class="breadcrumbs">Kørelærer &raquo; Chat</span>
    <div class="content">
        <form action="" method="post" class="chatForm">
            <input type="hidden" name="chat_id" id="chatid" value="<?= $getChatID["id"] ?>">
            <?php
            if ($userType["usertype"] == 1) {
                ?>
                <input type="hidden" name="receiver" id="receiver" value="<?= $getChatID["teacher_id"] ?>">
                <?php
            } else {
                ?>
                <input type="hidden" name="receiver" id="receiver" value="<?= $getChatID["user_id"] ?>">
                <?php
            }

            if($checkRejected["accepted"] == 1){
                ?>
                <textarea name="message" placeholder="Besked" required></textarea>
                <input type="submit" name="write" value="Skriv">
                <?php
            }
            ?>
        </form>
        <?php
            if($checkRejected["accepted"] == 0) {
                ?>
                <form action="" method="post" class="chatForm">
                    <input type="hidden" name="chat_id" id="chatid" value="<?= $getChatID["id"] ?>">
                    <?php
                    if ($userType["usertype"] == 1) {
                        ?>
                        <input type="hidden" name="receiver" id="receiver" value="<?= $getChatID["teacher_id"] ?>">
                        <?php
                    } else {
                        ?>
                        <input type="hidden" name="receiver" id="receiver" value="<?= $getChatID["user_id"] ?>">
                        <?php
                    }
                    ?>
                    <input type="submit" name="new" value="Vælg ny kørelærer">
                </form>
                <?php
            }
        ?>
        <div class="divider"></div>
        <div class="chatBoxes"></div>
    </div>
    <?php
}
if(!isset($_GET["cid"]) && checkUserType($link, $_SESSION["user_id"]) == 2){
    ?>
    <h1>Vælg elev</h1>
    <span class="breadcrumbs">Elever &raquo; Chat</span>
    <div class="content">
        <table id="koerelaerer" class="display" cellspacing="0" width="100%" style="width: 100%;">
            <thead>
            <tr>
                <th>Fornavn</th>
                <th>Efternavn</th>
                <th>By</th>
                <th>Beskeder</th>
                <th>Chat</th>
            </tr>
            </thead>
            <tbody>
            <?=chatList($link, $_SESSION["user_id"])?>
            </tbody>
            <tfoot>
            <tr>
                <th>Fornavn</th>
                <th>Efternavn</th>
                <th>By</th>
                <th>Beskeder</th>
                <th>Chat</th>
            </tr>
            </tfoot>
        </table>
    </div>
    <?php
} elseif(isset($_GET["cid"]) && checkUserType($link, $_SESSION["user_id"]) == 2) {
    $cid = isset($_GET['cid']) ? $_GET['cid'] : '';
    $checkChat = mysqli_query($link, "SELECT * FROM chat WHERE id='{$cid}' AND teacher_id='{$_SESSION["user_id"]}'");
    if(mysqli_num_rows($checkChat) < 1){
        messagebox("error", "Dette er ikke din chat.");
    } else {
        ?>
        <h1>Chat</h1>
        <span class="breadcrumbs">Elever &raquo; Chat</span>
        <div class="content">
            <form action="" method="post" class="chatForm">
                <textarea name="message" placeholder="Besked" required></textarea>
                <input type="hidden" name="chat_id" id="chatid" value="<?= $_GET["cid"] ?>">
                <input type="hidden" name="receiver" id="receiver" value="<?= $getChatID["user_id"] ?>">
                <input type="submit" name="write" value="Skriv">
            </form>
            <div class="divider"></div>
            <div class="chatBoxes"></div>
        </div>
        <?php
    }
}
    ?>
<?php
include("cp.footer.php");
?>