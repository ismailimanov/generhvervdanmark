<?php
include("cp.header.php");
?>
<h1>Chat</h1>
<span class="breadcrumbs">Kørelærer &raquo; Chat</span>
<div class="content">
    <form action="<?=$_SERVER["PHP_SELF"]?>" method="post" class="chatForm">
        <textarea name="message" placeholder="Besked"></textarea>
        <input type="submit" name="write" value="Skriv">
    </form>
    <div class="divider"></div>
    <div class="chatBoxes">
        <div class="chatBox cLeft">
            <span>Hej Ismail. Har du tid i næste uge?</span>
            <span class="chatBox--info">Kørelærer - 17:38 17.12.17</span>
        </div>
        <div class="chatBox cRight">
            <span>Hej Kørelærer. Hvornår kan jeg få min næste køretime?</span>
            <span class="chatBox--info">17:36 17.12.17 - Ismail</span>
        </div>
    </div>
</div>
<?php
include("cp.footer.php");
?>