<?php
include("cp.header.php");

if(isset($_POST["reject"])){
    $id =       filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid id");
    $message =  filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING) or messagebox("error", "Invalid besked");

    rejectStudent($link, $_SESSION["user_id"], $id, $message);
}
?>
<h1>Afvis elev</h1>
<span class="breadcrumbs">Elever &raquo; Ansøgninger &raquo; Afvis</span>
<div class="content">
    <form action="" method="post" class="chatForm">
        <textarea name="message" placeholder="Besked" required></textarea>
        <input type="submit" name="reject" value="Afvis" onclick="return confirm('Er du sikker på at du vil afvise?')">
    </form>
</div>
<?php
include("cp.footer.php");
?>
