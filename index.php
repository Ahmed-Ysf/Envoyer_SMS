
<?php

require("/home/USERS/ELEVES/SNIR2019/ayousfi/public_html/Envoyer_SMS/fonction_bdd_inc.php");

position($altitude2, $longitude2, $latitude2, $diff);
if ($altitude2 < 2000 && $diff > 10 ) {
    $retour = EnvoyerSMS(NUMERO, "l'altitude : $altitude2 , la longitude : $longitude2,"
            . " la latitude : $latitude2", CLE_API);
    echo $retour;
}
?>

