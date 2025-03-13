<?php
function generateCarteUtilisateur($idUtilisateur, $sortie, $numAdherent)
{
	include('connexion.php');
	$nom=NULL;
	$prenom=NULL;
	$dateAdhesion=NULL;
	$numResident=NULL;
	$urlPhoto=NULL;
	$typeAdherent=NULL;
    
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * from utilisateur WHERE idUtilisateur='.$idUtilisateur);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	
	
	foreach ($lignes as $colonne)
	{  
		$nom=$colonne->nom;
		$prenom=$colonne->prenom;
		$dateAdhesion=$colonne->dateAdhesion;
		$numResident=$colonne->numResident;
		$urlPhoto=$colonne->urlPhoto;
		$typeAdherent=$colonne->typeAdherent;
	}
    return  $numAdherent;
}
?>