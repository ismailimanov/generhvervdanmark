<?php
include("cp.header.php");
if(isset($_POST["update"])){
    $panelText = filter_input(INPUT_POST, 'panelText') or messagebox("error", "Ugyldig tekst");

    updateFrontpage($link, $panelText);
}

$getText = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM panelText WHERE id='1'"));
?>
<h1>Forsidetekster</h1>
<span class="breadcrumbs">Admin &raquo; Tekster</span>
<form action="" method="post" class="panelText">
    <textarea name="panelText" id="panelText"><?=$getText["panelText"]?></textarea>
    <input type="submit" name="update" value="Opdater">
</form>
<?php
include("cp.footer.php");
?>