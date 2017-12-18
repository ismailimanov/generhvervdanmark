<?php
include("cp.header.php");

if(isset($_GET["delete"])){
    $id = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_STRING) or messagebox("error", "Ugyldig lærer id");
    deleteStudent($link, $id);
}

?>
    <div class="newButton" onclick="location.href='ny-kørelærer';"><i class="fa fa-plus"></i></div>
    <h1>Elevliste</h1>
    <span class="breadcrumbs">Admin &raquo; Elever</span>
    <div class="content">
        <table id="koerelaerer" class="display" cellspacing="0" width="100%" style="width: 100%;">
            <thead>
            <tr>
                <th>Fornavn</th>
                <th>Efternavn</th>
                <th>By</th>
                <th>Telefonnumer</th>
                <th>Handlinger</th>
            </tr>
            </thead>
            <tbody>
            <?=students($link)?>
            </tbody>
            <tfoot>
            <tr>
                <th>Fornavn</th>
                <th>Efternavn</th>
                <th>By</th>
                <th>Telefonnummer</th>
                <th>Handlinger</th>
            </tr>
            </tfoot>
        </table>
    </div>
<?php
include("cp.footer.php");
?>