<?php
include("cp.header.php");

if(isset($_GET["teacherid"])){
    $teacher      = filter_input(INPUT_GET, 'teacherid', FILTER_SANITIZE_STRING) or messagebox("error", "Ugyldig lærer id");

    selectTeacher($link, $_SESSION["user_id"], $teacher);
}

?>
<h1>Vælg kørelærer</h1>
<span class="breadcrumbs">Kørelærer &raquo; Vælg kørelærer</span>
<div class="content">
    <table id="koerelaerer" class="display" cellspacing="0" width="100%" style="width: 100%;">
        <thead>
            <tr>
                <th>Fornavn</th>
                <th>Efternavn</th>
                <th>By</th>
                <th>Vurdering</th>
                <th>Vælg</th>
            </tr>
        </thead>
        <tbody>
            <?=teacherList($link)?>
        </tbody>
        <tfoot>
            <tr>
                <th>Fornavn</th>
                <th>Efternavn</th>
                <th>By</th>
                <th>Vurdering</th>
                <th>Vælg</th>
            </tr>
        </tfoot>
    </table>
</div>
<?php
include("cp.footer.php");
?>
