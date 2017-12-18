<?php
include("cp.header.php");

if(isset($_GET["success"])){
    messagebox("success", "Din betaling er nu gennemført! Du har nu adgang til de forskellige services.");
}

if(isset($_GET["betalt"])){
    $uxtime         = filter_input(INPUT_GET, 'uxtime', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid uxtime");
    $merchantnumber = filter_input(INPUT_GET, 'MerchantNumber', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid merchantnumber");
    $tid            = filter_input(INPUT_GET, 'tid', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid tid");
    $tchecksum      = filter_input(INPUT_GET, 'tchecksum', FILTER_SANITIZE_STRING) or messagebox("error", "Invalid tchecksum");
    $checksum       = filter_input(INPUT_GET, 'checksum', FILTER_SANITIZE_STRING) or messagebox("error", "Invalid checksum");
    $orderid        = filter_input(INPUT_GET, 'orderid', FILTER_SANITIZE_STRING) or messagebox("error", "Invalid orderid");
    $shopplatform   = filter_input(INPUT_GET, 'ShopPlatform', FILTER_SANITIZE_STRING) or messagebox("error", "Invalid shopplatform");
    $amount         = filter_input(INPUT_GET, 'amount', FILTER_SANITIZE_STRING) or messagebox("error", "Invalid amount");
    $split          = filter_input(INPUT_GET, 'split', FILTER_SANITIZE_STRING);
    $date           = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid date");
    $cvc            = filter_input(INPUT_GET, 'cvc', FILTER_SANITIZE_NUMBER_INT);
    $expmonth       = filter_input(INPUT_GET, 'expmonth', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid expmonth");
    $expyear        = filter_input(INPUT_GET, 'expyear', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid expyear");
    $tcardno        = filter_input(INPUT_GET, 'tcardno', FILTER_SANITIZE_STRING) or messagebox("error", "Invalid tcardno");
    $time           = filter_input(INPUT_GET, 'time', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid time");
    $cardid         = filter_input(INPUT_GET, 'cardid', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid cardid");
    $currency       = filter_input(INPUT_GET, 'currency', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Invalid currency");

    paymentSuccessful($link, $_SESSION["user_id"], $uxtime, $merchantnumber, $tid, $tchecksum, $checksum, $orderid, $shopplatform, $amount, $split, $date, $cvc, $expmonth, $expyear, $tcardno, $time, $cardid, $currency);
} else {
    ?>
    <h1>Betaling</h1>
    <p>Vores system har ikke registreret nogen betaling fra din konto.</p>
    <p>Du kan klikke på knappen nedenunder for at komme videre til betalingssiden.</p>
    <p>Hvis du tror at dette er en fejl, bedes du venligst tage kontakt til Generhverv Danmark.</p>
    <br>
    <div class="content">
        <form action="https://payments.yourpay.se/betalingsvindue.php" method="post" class="chatForm">
            <input type="hidden" name="MerchantNumber" value="60004771">
            <input type="hidden" name="ShopPlatform" value="Generhverv-Danmark">
            <input type="hidden" name="accepturl" value="http://192.168.0.17:7883/generhvervdanmark/betaling?betalt">
            <input type="hidden" name="time" value="<?= time() ?>">
            <input type="hidden" name="autocapture" value="yes">
            <input type="hidden" name="amount" value="150000">
            <input type="hidden" name="currency" value="208">
            <input type="hidden" name="lang" value="da-dk">
            <br><br>
            <input type="submit" value="Klik her for at åbne betalingsvinduet"
                   class="fusion-button button-flat button-round button-large button-custom button-1 btn-orange-hover-light">
        </form>
    </div>
    <?php
}
include("cp.footer.php");
?>