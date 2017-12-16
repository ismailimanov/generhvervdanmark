<?php
include("cp.header.php");

if(isset($_POST["write"])){
    $review      = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_STRING) or messagebox("error", "Ugyldig fornavn");

    writeReview($link, $_SESSION["user_id"], $review);
}

$getInfo = mysqli_query($link, "SELECT * FROM reviews WHERE id='{$_SESSION["user_id"]}'");
$info = mysqli_fetch_assoc($getInfo);
$check = mysqli_num_rows($getInfo);
?>
<h1>Skriv anmeldelse</h1>
<p class="info">Her kan du skrive en anmeldelse om Generhverv Danmark og de services som vi tilbyder.</p>
<p class="info">Udvalgte anmeldelser vil stå på forsiden.</p>
<p class="info">Dit efternavn vil selvfølgelig ikke være synlig.</p>
<div class="content">
    <form action="<?=$_SERVER["PHP_SELF"]?>" method="post">
        <textarea name="review" placeholder="Din anmeldelse"<?php if($check > 0){ echo ' disabled'; } ?> required><?php if($check > 0){ echo $info["review"]; } ?></textarea>
        <input type="submit" name="write" value="Skriv"<?php if($check > 0){ echo ' disabled'; } ?>>
    </form>
</div>
<?php
include("cp.footer.php");
?>
