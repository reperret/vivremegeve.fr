<?php


function getUserVivreMegeve($numAdherent,$dbh)
{
    $infosAdherent=array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query("SELECT * from utilisateur where numAdherent='".$numAdherent."'");
    $lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
    foreach ($lignes as $colonne)
    {
        $infosAdherent['idUtilisateur']=$colonne->idUtilisateur;
        $infosAdherent['numAdherent']=$colonne->numAdherent;
        $infosAdherent['nomAdherent']=$colonne->nom;
    }
    return $infosAdherent;
}

function getUserVivreMegeve2($numAdherent,$nomAdherent,$dbh)
{
    $infosAdherent=array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query("SELECT * from utilisateur where numAdherent='".$numAdherent."' or nomAdherent LIKE '%".$nomAdherent."%'");
    $lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
    foreach ($lignes as $colonne)
    {
        $infosAdherent[0]['idUtilisateur']=$colonne->idUtilisateur;
        $infosAdherent[0]['numAdherent']=$colonne->numAdherent;
        $infosAdherent[0]['nomAdherent']=$colonne->nom;
    }
    return $infosAdherent;
}


?>