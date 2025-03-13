<?php
include '../connexion.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.vivremegeve.fr/api/vivremegeve.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);

$auth="aiovbZRUOGTzbrvZRUGB,??452";


//**************************************************************************************
//**************************************************************************************
//********************************APPEL FONCTIONS******************************************
//**************************************************************************************
//**************************************************************************************

if(isset($_GET['test']) && $_GET['test']=='0')
{
    $method='getUserVivreMegeve';
    $numAdherent=$_GET['numAdherent'];
    
    $data = array(
    'auth'                  => $auth,
    'method'                => $method,
    'numAdherent'           => $numAdherent,
    );
}


if(isset($_GET['test']) && $_GET['test']=='1')
{
    $method='getUserVivreMegeve2';
    $numAdherent=$_GET['numAdherent'];
    $nomAdherent=$_GET['nomAdherent'];
    
    $data = array(
    'auth'                  => $auth,
    'method'                => $method,
    'numAdherent'           => $numAdherent,
    'nomAdherent'           => $nomAdherent,
    );
}

//********APPEL DE LA FONCTION EN PASSANT LES PARAMETRES*******************
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output = curl_exec($ch);
$info = curl_getinfo($ch); 
curl_close($ch);


//*********AFFICHAGE DU RETOUR DE L'API******************

echo $output;

    
?>