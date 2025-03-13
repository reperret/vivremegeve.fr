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

echo calculSignature();


?>