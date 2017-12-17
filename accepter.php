<?php
include("cp.header.php");

if(isset($_POST["accept"])){
    $id =       filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid id");
    $message =  filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING) or messagebox("error", "Invalid besked");

    acceptStudent($link, $_SESSION["user_id"], $id, $message);
}
?>
<h1>Accepter elev</h1>
<span class="breadcrumbs">Elever &raquo; Ansøgninger &raquo; Accepter</span>
<div class="content">
    <form action="" method="post" class="chatForm">
        <textarea name="message" placeholder="Besked" required></textarea>
        <input type="submit" name="accept" value="Accepter">
    </form>
</div>
<?php
include("cp.footer.php");
?>
