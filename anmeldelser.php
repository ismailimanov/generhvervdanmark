<?php
include("cp.header.php");
if(isset($_GET["accept"])){
    $id = filter_input(INPUT_GET, 'accept', FILTER_SANITIZE_NUMBER_INT) or messagebox("error", "Ugyldig ID");

    acceptReview($link, $id);
}
?>
<h1>Anmeldelser</h1>
<span class="breadcrumbs">Admin &raquo; Anmeldelser</span>
    <div class="content">
        <table id="koerelaerer" class="display" cellspacing="0" width="100%" style="width: 100%;">
            <thead>
            <tr>
                <th>Fornavn</th>
                <th>Efternavn</th>
                <th>Anmeldelse</th>
                <th>Handlinger</th>
            </tr>
            </thead>
            <tbody>
            <?=reviews($link)?>
            </tbody>
            <tfoot>
            <tr>
                <th>Fornavn</th>
                <th>Efternavn</th>
                <th>Anmeldelse</th>
                <th>Handlinger</th>
            </tr>
            </tfoot>
        </table>
    </div>
<?php
include("cp.footer.php");
?>