<?php
require_once("lib/Payplug.php");
include('../connexion.php'); 
Payplug::setConfigFromFile("parameters.json");

try 
{	
	$ipn = new IPN();	

	//******************** MISE A JOUR CHAMP PAIEMENT************************
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$reqUpdate = $dbh->prepare("UPDATE utilisateur SET paiement=1, transactionPaiement=? , datePaiement=? WHERE idUtilisateur=?");
	$reqUpdate->bindParam(1,$ipn->idTransaction); 
	$reqUpdate->bindParam(2,date("Y-m-d H:i:s"));
	$reqUpdate->bindParam(3,$ipn->order);
	$reqUpdate->execute();
	//******************** FIN MISE A JOUR CHAMP PAIEMENT************************
	
		
	//******************** RECUPERATION INFORMATION CLIENT ************************
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * from utilisateur WHERE idUtilisateur='.$ipn->order);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	$ddn=NULL;
	$dateAdhesion=NULL;
	$numResident=NULL;
	$numAdherent=NULL;
	$typeAdherent=NULL;
	$urlCarte=NULL;
	foreach ($lignes as $colonne)
	{ 
		$ddn=$colonne->ddn;
		$dateAdhesion=$colonne->dateAdhesion;
		$numResident=$colonne->numResident;
		$numAdherent=$colonne->numAdherent;
		$typeAdherent=$colonne->typeAdherent;
		$urlCarte=$colonne->urlCarte;	
	}	
	$resultats->closeCursor();	
	//******************** RECUPERATION URL CARTE FIN************************
	
	
	
	
	//******************** ENVOI MAIL ************************
	$nom=$ipn->firstName;
	$prenom=$ipn->lastName;
	$email=$ipn->email;
	require('../mail/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->From = "contact@vivremegeve.fr";
	$mail->FromName = "Vivre Megève";
	$mail->Subject = "confirmation inscription";						 
	$body = "<center>
<img src='".$domaine."images/logoMail.jpg'></center><br><br>
Bonjour ".$prenom." ".$nom."<br>
	
Nous vous remercions pour votre inscription. Vous êtes désormais adhérent à l'association Vivre Megève.<br><br>

Vous pouvez dès maintenant récupérer votre carte d'adhérent sur votre <a href=\"".$domaine."compteclient.php\">Espace client</a> ou en pièce jointe à ce mail.<br><br>

Le président, André PERRET.";
	
	$mail->MsgHTML($body);			 
	// Il reste encore à ajouter au moins un destinataire
	$mail->AddAddress($email, $nom." ".$prenom);
	$mail->AddAttachment('../cartesGenerees/'.$urlCarte);
	$mail->send();
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
	//$mail->AddAddress($emailWebmasterAlerte, "SEM");
	$mail->AddAddress("resp-caisse.ro@ski.megeve.com", "SEM");
	
	$mail->send();
					
	//******************** FIN GENERATION EMAIL CONFIRMATION SEM ET VIVREMEGEVE************************

} 
catch (InvalidSignatureException $e) 
{
    mail($emailWebmasterAlerte,"IPN Failed","The signature was invalid");
}

?>