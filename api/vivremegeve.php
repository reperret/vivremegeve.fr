<?php
header("Access-Control-Allow-Origin: *");
$json = file_get_contents('php://input');
$obj = json_decode($json);
$method = NULL;
$auth = NULL;
$method = $_POST['method'];
$auth = $_POST['auth'];

include '../connexion.php';

// Vérification du User-Agent
if (!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT'])) {
    $data = array();
    $data["message"] = "ERROR_MISSING_USER_AGENT";
    echo json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
    exit();
}

function getUserVivreMegeve($numAdherent, $dbh)
{
    $infosAdherent = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query("SELECT * from utilisateur where numAdherent='" . $numAdherent . "'");
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    foreach ($lignes as $colonne) {
        $validiteAdherent = false;
        $dateFinValidite = NULL;
        $renouvellement = $colonne->renouvellement;
        $paiement = $colonne->paiement;
        if ($renouvellement == 0 && $paiement == 1) $validiteAdherent = true;
        if ($validiteAdherent) {
            $annee = intval(date('Y'));
            $mois = intval(date('m'));
            if ($mois < 9 && $mois > 0) $dateFinValidite = $annee . "-08-31";
            if ($mois >= 9 && $mois <= 12) $dateFinValidite = ($annee + 1) . "-08-31";
        }

        $infosAdherent['civiliteAdherent'] = $colonne->civilite;
        $infosAdherent['typeAdherent'] = $colonne->typeAdherent;
        $infosAdherent['numAdherent'] = $colonne->numAdherent;
        $infosAdherent['numResident'] = $colonne->numResident;
        $infosAdherent['nomAdherent'] = $colonne->nom;
        $infosAdherent['prenomAdherent'] = $colonne->prenom;
        $infosAdherent['ddnAdherent'] = $colonne->ddn;
        $infosAdherent['adresseAdherent'] = preg_replace("/\r\n|\r|\n/", ' ', $colonne->adresse);
        $infosAdherent['cpAdherent'] = $colonne->code_postal;
        $infosAdherent['villeAdherent'] = $colonne->ville;
        $infosAdherent['telephoneAdherent'] = $colonne->telephone;
        $infosAdherent['emailAdherent'] = $colonne->email;
        $infosAdherent['validiteAdherent'] = $validiteAdherent;
        $infosAdherent['dateFinValiditeAdherent'] = $dateFinValidite;
    }
    return $infosAdherent;
}

function getUserVivreMegeve2($numAdherent, $dbh)
{
    $infosAdherent = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $requete = "SELECT * from utilisateur where numAdherent='" . $numAdherent . "' or nom LIKE '%" . $numAdherent . "%'";

    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    $i = 0;
    foreach ($lignes as $colonne) {
        $validiteAdherent = false;
        $dateFinValidite = NULL;
        $renouvellement = $colonne->renouvellement;
        $paiement = $colonne->paiement;
        if ($renouvellement == 0 && $paiement == 1) $validiteAdherent = true;
        if ($validiteAdherent) {
            $annee = intval(date('Y'));
            $mois = intval(date('m'));
            if ($mois < 9 && $mois > 0) $dateFinValidite = $annee . "-08-31";
            if ($mois >= 9 && $mois <= 12) $dateFinValidite = ($annee + 1) . "-08-31";
        }

        $infosAdherent[$i]['civiliteAdherent'] = $colonne->civilite;
        $infosAdherent[$i]['typeAdherent'] = $colonne->typeAdherent;
        $infosAdherent[$i]['numAdherent'] = $colonne->numAdherent;
        $infosAdherent[$i]['numResident'] = $colonne->numResident;
        $infosAdherent[$i]['nomAdherent'] = $colonne->nom;
        $infosAdherent[$i]['prenomAdherent'] = $colonne->prenom;
        $infosAdherent[$i]['ddnAdherent'] = $colonne->ddn;
        $infosAdherent[$i]['adresseAdherent'] = preg_replace("/\r\n|\r|\n/", ' ', $colonne->adresse);
        $infosAdherent[$i]['cpAdherent'] = $colonne->code_postal;
        $infosAdherent[$i]['villeAdherent'] = $colonne->ville;
        $infosAdherent[$i]['telephoneAdherent'] = $colonne->telephone;
        $infosAdherent[$i]['emailAdherent'] = $colonne->email;
        $infosAdherent[$i]['validiteAdherent'] = $validiteAdherent;
        $infosAdherent[$i]['dateFinValiditeAdherent'] = $dateFinValidite;
        $i++;
    }
    return $infosAdherent;
}

//*****************************************
//********RECEPTION DES APPEL*************
//*****************************************

//********VERIFICATION EMETTEUR*************
if ($auth == "aiovbZRUOGTzbrvZRUGB,??452") {
    switch ($method) {
            //***************************************************
            //*********getUserVivreMegeve*****************
            //***************************************************
        case 'getUserVivreMegeve':
            if (
                (isset($_POST['numAdherent']) && $_POST['numAdherent'] != '')
            ) {
                echo json_encode(getUserVivreMegeve($_POST['numAdherent'], $dbh), JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
            } else {
                $data = array();
                $data["codeErreur"] = 'ERROR_MISSING_PARAMETERS';
                echo json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
            }
            break;

            //***************************************************
            //*********getUserVivreMegeve2*****************
            //***************************************************
        case 'getUserVivreMegeve2':
            if (
                (isset($_POST['numAdherent']) && $_POST['numAdherent'] != '')
            ) {
                echo json_encode(getUserVivreMegeve2($_POST['numAdherent'], $dbh), JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
            } else {
                $data = array();
                $data["codeErreur"] = 'ERROR_MISSING_PARAMETERS';
                echo json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
            }
            break;

            //***************COMPORTEMENT PAR DEFAUT SI METHODED NON TROUVEE********************
        default:
            $data = array();
            $data["codeErreur"] = 'UNKNOWN_METHOD';
            $data["message"] = 'Méthode demandée inconnue';
            echo json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
    }
} else {
    $data = array();
    $data["message"] = "ERROR_AUTH_FAILED";
    echo json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
}
