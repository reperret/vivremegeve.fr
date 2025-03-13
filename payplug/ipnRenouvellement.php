<?php
require_once("lib/Payplug.php");
include('../connexion.php'); 
Payplug::setConfigFromFile("parameters.json");

try 
{	
	$ipn = new IPN();	

    		
	//******************** RECUPERATION INFORMATION CLIENT ************************
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * from utilisateur WHERE idUtilisateur='.$ipn->order);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	$ddn=NULL;
	$dateAdhesion=NULL;
	$numResident=NULL;
	$numAdherent=NULL;
	$typeAdherent=NULL;
	foreach ($lignes as $colonne)
	{ 
		$ddn=$colonne->ddn;
		$dateAdhesion=$colonne->dateAdhesion;
		$numResident=$colonne->numResident;
		$numAdherent=$colonne->numAdherent;
		$typeAdherent=$colonne->typeAdherent;	
	}	
	$resultats->closeCursor();	
    
    
	//******************** RECUPERATION URL CARTE FIN************************
	//**** Génération de la carte PDF  ****
	include('../generationCarteAdherentFonction.php');
	$urlCarte=generateCarteUtilisateur($ipn->order,'',$numAdherent);
	//**** FIN Génération de la carte PDF + numéro adhérentr ****


	//******************** MISE A JOUR CHAMP PAIEMENT************************
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$reqUpdate = $dbh->prepare("UPDATE utilisateur SET renouvellement=0 WHERE idUtilisateur=?");
    $reqUpdate->bindParam(1,$ipn->order);
	$reqUpdate->execute();
	//******************** FIN MISE A JOUR CHAMP PAIEMENT************************
	
	

    $reqInsert = $dbh->prepare("INSERT INTO renouvellement (transactionRenouvellement,date,idUtilisateur,montant,urljustificatif, paiement) VALUES (?, ?, ? ,? ,? ,?)");
    $dateRenouvellement = new DateTime();					
    $reqInsert->bindParam(1, $ipn->idTransaction);
    $reqInsert->bindParam(2, $dateRenouvellement->format('Y-m-d H:i:s'));
    $reqInsert->bindParam(3,$ipn->order);
    $reqInsert->bindParam(4,intval($montantAnneeEnCours));
    $reqInsert->bindParam(5,$urlCarte);
    $reqInsert->bindParam(6,intval("1"));
	
	$reqInsert->execute();

	

	
	
	
	
	//******************** ENVOI MAIL ************************
	$nom=$ipn->firstName;
	$prenom=$ipn->lastName;
	$email=$ipn->email;
	require('../mail/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->From = "contact@vivremegeve.fr";
	$mail->FromName = "Vivre Megève";
	$mail->Subject = "confirmation renouvellement";						 
	$body = "Bonjour<br><br>
	
Nous vous remercions pour votre renouvellement. Vous êtes à nouveau adhérent à l'association Vivre Megève pour une année supplémentaire.<br><br>

Vous pouvez dès maintenant récupérer votre nouvelle carte d'adhérent sur votre espace adhérent en cliquant ci dessous ou en pièce jointe de ce mail.<br><br>

La présidente, Annick SOCQUET CLERC.";
	
	$mail->MsgHTML($body);			 
	// Il reste encore à ajouter au moins un destinataire
	$mail->AddAddress($email, $nom." ".$prenom);
	$mail->AddAttachment('../cartesGenerees/'.$urlCarte);
	$mail->send();


	$envoi=sendMail($email, "Confirmation renouvellement", $body, "Accès espace adhérent", $domaine."compteclient.php", "6330280", "confirmation renouvellement", '../cartesGenerees/'.$urlCarte);

	//******************** FIN GENERATION EMAIL CONFIRMATION CLIENT************************
	
	
	//******************** GENERATION EMAIL CONFIRMATION SEM ET VIVRE MEGEVE************************
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->From = "contact@vivremegeve.fr";
	$mail->FromName = "Vivre Megève";
	$mail->Subject = "nouveau renouvellement Vivre Megève";						 
	$body = "
	Nom : ".$nom."<br>
	Prénom : ".$prenom."<br>
	Date Naissance : ".$ddn."<br>
	N° Adhérent : ".$numAdherent."<br>
	N° Carte résident : ".$numResident."<br>
	Type Adhérent : ".$typeAdherent;

	$mail->MsgHTML($body);			 
	//$mail->AddAddress($emailWebmasterAlerte, "SEM");
	$mail->AddAddress($emailAlerteSem, "SEM");
	
	$mail->send();
					
	//******************** FIN GENERATION EMAIL CONFIRMATION SEM ET VIVREMEGEVE************************

} 
catch (InvalidSignatureException $e) 
{
    mail($emailWebmasterAlerte,"IPN Failed","The signature was invalid");
}

?>