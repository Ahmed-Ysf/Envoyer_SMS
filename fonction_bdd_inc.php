<?php

define("SERVEURBD", "172.18.58.63");
define("LOGIN", "root");
define("MOTDEPASSE", "toto");
define("NOMDELABASE", "ballon2021");
define("URL", "http://touchardinforeseau.servehttp.com/Ruche/api/sendSMS");
define("NUMERO", "0766046565");
define("CLE_API", "DTJ58NCQSV");

/**
 * @brief crée la connexion avec la base de donnée et retourne l'objet PDO pour manipuler la base
 * @return \PDO
 */
function connexionBdd() {
    try {
        $pdoOptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $bdd = new PDO('mysql:host=' . SERVEURBD . ';dbname=' . NOMDELABASE, LOGIN, MOTDEPASSE, $pdoOptions);
        $bdd->exec("set names utf8");
        return $bdd;
    } catch (PDOException $e) {
// En cas d'erreur, on affiche un message et on arrête tout
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function position(&$altitude2, &$longitude2, &$latitude2,&$diff,&$diff1) {
    try {
        // connexion BDD
        $bdd = connexionBdd();
        $requete = $bdd->query("select altitude,longitude,latitude from ballon "
                . "order by horodatage DESC LIMIT 2; ");
        $ligne1 = $requete->fetch();
        $ligne2 = $requete->fetch();
        $altitude1 = $ligne2['altitude'];
        $altitude2 = $ligne1['altitude'];
        $longitude2 = $ligne1['longitude'];
        $latitude2 = $ligne1['latitude'];
       
        $diff = ($altitude2 - $altitude1);
        $diff1 = ($altitude1 - $altitude2);
        
        
        



        // libération des ressources de la requête
        $requete->closeCursor();
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function EnvoyerSMS($numero, $message, $key) {

    $curl = curl_init();
    $postfields = 'key=' . $key . '&number=' . $numero . '&message=' . $message;
    $options = array(
        CURLOPT_URL => URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postfields,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded"
    ));
    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}
