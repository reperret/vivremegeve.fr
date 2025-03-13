<?php
//**************VERIFICATION ADMIN**********************
	session_start();
	$admin=NULL;
	$profilAdmin=NULL;
	$idAdministrateur=NULL;
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * From administrateur WHERE login LIKE "'.$_SESSION['login'].'"');
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	
	foreach ($lignes as $colonne)
	{
		$admin=$colonne->droit;	
		$idAdministrateur=$colonne->idAdministrateur;
		$nom=$colonne->nom;
		$prenom=$colonne->prenom;
		$profilAdmin=$colonne->droit;
	}	
	$resultats->closeCursor();	
	

	
	if (!isset($_SESSION['login'])) 
	{
		header ('Location: authentification.php');
		exit();
	}

				
//************Renvoi 1 ou 0 selon si la personne est admin ou non******************
?>