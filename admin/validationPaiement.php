<?php
include('../connexion.php'); 

try 
{		

	$idUtilisateur=$_POST['idUtilisateur'];
	//******************** MISE A JOUR CHAMP PAIEMENT************************
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$reqUpdate = $dbh->prepare("UPDATE utilisateur SET paiement=1, datePaiement=? WHERE idUtilisateur=?");
	$reqUpdate->bindParam(1,date("Y-m-d H:i:s"));
	$reqUpdate->bindParam(2,$idUtilisateur);
	$reqUpdate->execute();
	//******************** FIN MISE A JOUR CHAMP PAIEMENT************************
	
		
	//******************** RECUPERATION INFORMATION CLIENT ************************
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * from utilisateur WHERE idUtilisateur='.$idUtilisateur);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	$ddn=NULL;
	$dateAdhesion=NULL;
	$numResident=NULL;
	$numAdherent=NULL;
	$typeAdherent=NULL;
	$urlCarte=NULL;
	$nom=NULL;
	$prenom=NULL;
	$email=NULL;
    $codeMairie=NULL;
	foreach ($lignes as $colonne)
	{ 
		$ddn=$colonne->ddn;
		$dateAdhesion=$colonne->dateAdhesion;
		$numResident=$colonne->numResident;
		$numAdherent=$colonne->numAdherent;
		$typeAdherent=$colonne->typeAdherent;
		$urlCarte=$colonne->urlCarte;	
		$nom=$colonne->nom;
		$prenom=$colonne->prenom;
		$email=$colonne->email;
        $codeMairie=$colonne->codeMairie;
	}	
	$resultats->closeCursor();	
	//******************** RECUPERATION URL CARTE FIN************************
	
    
    
    //***********MISE A JOUR CODE ********************
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $reqUpdate = $dbh->prepare("UPDATE code set dateUtilisationCode=?, idUtilisateur=? where valeurCode=?");
    $reqUpdate->bindParam(1,$dateUtilisationCode); 
    $reqUpdate->bindParam(2,$idUtilisateur);
    $reqUpdate->bindParam(3,$codeMairie);
    $dateUtilisationCode=date('Y-m-d H:i:s');
    $reqUpdate->execute();
    //**********FIN MISE A JOUR CODE ********************
	
	
	
	//******************** ENVOI MAIL ************************

	require('../mail/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->From = "contact@vivremegeve.fr";
	$mail->FromName = "Vivre Megève";
	$mail->Subject = "confirmation inscription";						 
	$body = "Bonjour,<br><br>
	
Nous vous remercions pour votre inscription. Vous êtes désormais adhérent à l'association Vivre Megève.<br><br>

Vous pouvez dès maintenant récupérer votre carte d'adhérent sur votre Espace client en cliquant ci dessous ou en pièce jointe à ce mail.<br><br>

La présidente, Annick SOCQUET CLERC.";
	
	$mail->MsgHTML($body);			 
	// Il reste encore à ajouter au moins un destinataire
	$mail->AddAddress($email, $nom." ".$prenom);
	$mail->AddAttachment('../cartesGenerees/'.$urlCarte);
	$mail->send();

	$envoi=sendMail($email, "Confirmation inscription", $body, "Accès espace adhérent", $domaine."compteclient.php", "6330280", "confirmation inscription", '../cartesGenerees/'.$urlCarte);

	//******************** FIN GENERATION EMAIL CONFIRMATION CLIENT************************
	
	
	//******************** GENERATION EMAIL CONFIRMATION SEM ET VIVRE MEGEVE************************
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->From = "contact@vivremegeve.fr";
	$mail->FromName = "Vivre Megève";
	$mail->Subject = "nouvel adhérent Vivre Megève";						 
	$body = "
	Nom : ".$nom."<br>
	Prénom : ".$prenom."<br>
	Date Naissance : ".$ddn."<br>
	N° Adhérent : ".$numAdherent."<br>
	N° Carte résident : ".$numResident."<br>
	Type Adhérent : ".$typeAdherent;

	$mail->MsgHTML($body);			 
	$mail->AddAddress($emailWebmasterAlerte, "SEM");
	$mail->AddAddress($emailAlerteSem, "SEM");
	
	$mail->send();
					
	//******************** FIN GENERATION EMAIL CONFIRMATION SEM ET VIVREMEGEVE************************


	header('Location: index.php');
} 
catch (InvalidSignatureException $e) 
{
    mail($emailWebmasterAlerte,"Validation Manuelle","Validation manuelle avortee adherent ".$numAdherent);
}

?>