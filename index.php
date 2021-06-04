
<?php

require("./fonction_bdd_inc.php");

position($altitude2, $longitude2, $latitude2, $diff);
echo "alt : $altitude2\n";
echo "diff : $diff\n";
if ($altitude2 < 2000 && $diff > 10 ) {
    $message = formerMessageSMS("C50EE9", $longitude2, $latitude2, $altitude2);
    $retour = EnvoyerSMS(NUMERO, $message, CLE_API);
    echo $retour;
}
?>
