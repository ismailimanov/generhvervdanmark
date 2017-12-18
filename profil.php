<?php
include("cp.header.php");
if(isset($_GET["id"])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING) or messagebox("error", "Ugyldig ID");
    $getInfo = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id='{$id}' AND usertype='1'"));
    $getPaymentCheck = mysqli_query($link, "SELECT * FROM payment WHERE user_id='{$id}'");
    $getPayment = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM payment WHERE user_id='{$id}'"));
    $getPaymentInfo = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM paymentInfo WHERE payment_id='{$getPayment["id"]}'"));
    ?>
    <h1>Profil</h1>
    <span class="breadcrumbs">Admin &raquo; Elever &raquo; <?=$getInfo["firstname"] . " " . $getInfo["lastname"]?></span>
    <div class="profile">
        <div class="profile--item">
            <span class="profile--item--heading"><span class="profile--item--heading--bold">For</span>navn</span>
            <?=$getInfo["firstname"]?>
        </div>
        <div class="profile--item">
            <span class="profile--item--heading"><span class="profile--item--heading--bold">Efter</span>navn</span>
            <?=$getInfo["lastname"]?>
        </div>
        <div class="profile--item">
            <span class="profile--item--heading"><span class="profile--item--heading--bold">Telefon</span>nummer</span>
            <?=$getInfo["phonenumber"]?>
        </div>
        <div class="profile--item">
            <span class="profile--item--heading"><span class="profile--item--heading--bold">Adr</span>esse</span>
            <?=$getInfo["address"]?>
        </div>
        <div class="profile--item">
            <span class="profile--item--heading"><span class="profile--item--heading--bold">Post</span>nummer</span>
            <?=$getInfo["zipcode"]?>
        </div>
        <div class="profile--item">
            <span class="profile--item--heading"><span class="profile--item--heading--bold">By</span>navn</span>
            <?=$getInfo["city"]?>
        </div>
        <div class="profile--item">
            <span class="profile--item--heading"><span class="profile--item--heading--bold">E-mail</span> adresse</span>
            <?=$getInfo["email"]?>
        </div>
        <div class="profile--item">
            <span class="profile--item--heading"><span class="profile--item--heading--bold">Bruger</span>navn</span>
            <?=$getInfo["username"]?>
        </div>
        <?php
            if(mysqli_num_rows($getPaymentCheck) > 0) {
                ?>
                <div class="profile--divider"></div>
                <h2><span class="bold">Betalings</span>oplysninger</h2>
                <div class="profile--item">
                    <span class="profile--item--heading"><span
                            class="profile--item--heading--bold">Betalings</span>id</span>
                    <?= $getPaymentInfo["payment_id"] ?>
                </div>
                <div class="profile--item">
                    <span class="profile--item--heading"><span
                            class="profile--item--heading--bold">Betalings</span>dato</span>
                    <?= $getPaymentInfo["date"] ?>
                </div>
                <div class="profile--item">
                    <span class="profile--item--heading"><span
                            class="profile--item--heading--bold">Betalings</span>beløb</span>
                    <?= $getPaymentInfo["amount"] / 100 ?>,- kr.
                </div>
                <div class="profile--item">
                    <span class="profile--item--heading"><span
                            class="profile--item--heading--bold">Kort</span>nummer</span>
                    <?= $getPaymentInfo["tcardno"] ?>
                </div>
                <div class="profile--item">
                    <span class="profile--item--heading"><span
                            class="profile--item--heading--bold">Udløbs</span>måned</span>
                    <?= $getPaymentInfo["expmonth"] ?>
                </div>
                <div class="profile--item">
                    <span class="profile--item--heading"><span
                            class="profile--item--heading--bold">Udløbs</span>år</span>
                    <?= $getPaymentInfo["expyear"] ?>
                </div>
                <?php
            }
        ?>
    </div>
    <?php
} else {
    header("Location: kontrolpanel");
    exit();
}
include("cp.footer.php");
?>