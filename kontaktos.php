<?php
include("header.php");
?>
    <div class="mapsContainer">
        <div class="mapsContainer--overlay"></div>
        <div class="mapsContainer--map" id="map"></div>
    </div>
    <div class="contactContainer">
        <div class="grid grid-pad">
            <div class="col-1-2">
                <div class="content">
                    <h1><b>Kontakt</b> Os</h1>
                    <p>Har du nogle spørgsmål, kan du kontakte os gennem kontaktformularen herunder. Vi vil forsøge på at svare dig tilbage hurtigst muligt.</p>
                    <form action="" method="post">
                        <input type="text" name="fuldenavn" placeholder="Fulde navn" required>
                        <input type="email" name="email" placeholder="E-mail adresse" required>
                        <input type="text" name="telefon" placeholder="Telefonnummer" required>
                        <textarea name="besked" placeholder="Besked"></textarea>
                        <input type="submit" name="send" value="Send Besked">
                    </form>
                </div>
            </div>
            <div class="col-1-2">
                <div class="content">
                    <h1><b>Kontakt</b>oplysninger</h1>
                    <span>Generhverv Danmark ApS</span>
                    <span>CVR: 38607022</span>
                    <span><i class="fa fa-envelope"></i> kontakt@generhvervdanmark.dk</span>
                    <span><i class="fa fa-phone"></i> 88 88 88 88</span>
                    <span><i class="fa fa-map-marker"></i> Åboulevard 39 1960 Frederiksberg C</span>
                </div>
            </div>
        </div>
    </div>
<?php
include("footer.php");
?>
