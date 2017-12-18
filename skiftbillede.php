<?php
include("cp.header.php");

if(isset($_POST["change"])){
    $folderName   = "uploads/";
    $time         = round(microtime(true) * 1000);
    $image        = $folderName . $time . "-" . basename($_FILES["image"]["name"]);
    $imageType    = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $imageFile    = $_FILES["image"];

    changeImage($link, $_SESSION["user_id"], $image, $imageType, $imageFile);
}
?>
<h1>Skift billede</h1>
<span class="breadcrumbs">Indstillinger &raquo; Skift billede</span>
<div class="content">
    <form action="" method="post" class="chatForm" enctype="multipart/form-data">
        <input type="file" name="image" class="full">
        <input type="submit" name="change" value="Skift billede">
    </form>
</div>
<?php
include("cp.footer.php");
?>