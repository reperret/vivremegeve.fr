<?php
try
{
	include('connexion.php');  

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	

	$listeLogins=NULL;

	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT login FROM utilisateur WHERE email="'.$_POST['email'].'"');
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	foreach ($lignes as $colonne)
	{ 
		$listeLogins=$listeLogins.$colonne->login."<br>";
	}	
	$resultats->closeCursor();	

	
	
		
		//**** Envoi mail avec le nouveau mdp*****
		require('mail/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->From = "contact@vivremegeve.fr";
		$mail->FromName = "Vivre Megève";
		$mail->Subject = "votre pseudonyme";			 
		$body = "Bonjour,<br><br>


Voici la liste des logins associés à cette adresse email : <br>".
$listeLogins."
<br><br>
Cordiales salutations.<br><br>

Vivre Megève";

		$mail->MsgHTML($body);
		//plusieurs destinataires = appeller plusieurs fois cette méthode
		$mail->AddAddress($_POST['email'], "Client"." "."login");
		$mail->send();
		//**** FIN Envoi mail confirmation client*****
		
		header ('Location: confirmationInformations.php');
} 
catch (InvalidSignatureException $e) 
{
    mail("reperret@hotmail.com","IPN Failed","The signature was invalid");
}

?>