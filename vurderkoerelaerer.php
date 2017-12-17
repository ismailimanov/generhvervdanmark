<?php
include("cp.header.php");

if(isset($_POST["review"])){
    $rating      = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_STRING) or messagebox("error", "Ugyldig fornavn");
    $getTeacher  = mysqli_query($link, "SELECT * FROM teacherStudent WHERE user_id='{$_SESSION["user_id"]}'");
    $teacher     = mysqli_fetch_assoc($getTeacher);

    rateTeacher($link, $_SESSION["user_id"], $teacher["teacher_id"], $rating);
}

$checkTeacher = mysqli_query($link, "SELECT * FROM teacherStudent WHERE user_id='{$_SESSION["user_id"]}'");
$checkReview = mysqli_query($link, "SELECT * FROM teacherRating WHERE user_id='{$_SESSION["user_id"]}'");
?>
<h1>Vurder kørelærer</h1>
<span class="breadcrumbs">Kørelærer &raquo; Vurder kørelærer</span>
<div class="content">
    <?php
        if(mysqli_num_rows($checkTeacher) == 0){
            echo "<p>Du skal vælge en kørelærer før du kan begynde med at vurdere.</p>";
        } elseif(mysqli_num_rows($checkReview) != 0){
            echo "<p>Du har allerede vurderet din kørelærer.</p>";
        } else {
            ?>
    <form action="<?=$_SERVER["PHP_SELF"]?>" method="post" class="reviewForm">
        <fieldset class="rating" aria-required="true">
            <input type="radio" id="star5" name="rating" value="5" /><label class="full" for="star5" title="5 stjerner - Klart over middel"></label>
            <input type="radio" id="star4" name="rating" value="4" /><label class="full" for="star4" title="4 stjerner - Over middel"></label>
            <input type="radio" id="star3" name="rating" value="3" /><label class="full" for="star3" title="3 stjerner - Middel"></label>
            <input type="radio" id="star2" name="rating" value="2" /><label class="full" for="star2" title="2 stjerner - Under middel"></label>
            <input type="radio" id="star1" name="rating" value="1" /><label class="full" for="star1" title="1 stjerne - Klart under middel"></label>
        </fieldset>
        <input type="submit" name="review" value="Vurder Kørelærer">
    </form>
    <?php
        }
    ?>
</div>
<?php
include("cp.footer.php");
?>
