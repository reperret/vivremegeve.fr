<?php
try
{
	include('connexion.php');  
	echo $_POST['login'];
	$newMDPClair=uniqid();
	$newMDP=md5($newMDPClair);
	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	$reqUpdate = $dbh->prepare("UPDATE utilisateur SET pass_md5=? WHERE login=?");
	$reqUpdate->bindParam(1,$newMDP); 
	$reqUpdate->bindParam(2,$_POST['login']);
	$reqUpdate->execute();
	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	$reqUpdate = $dbh->prepare("INSERT INTO logmdp SET passClair=?, dateNewMdp=?, login=?");
	$reqUpdate->bindParam(1,$newMDPClair); 
	$reqUpdate->bindParam(2,date("Y-m-d H:i:s")); 
	$reqUpdate->bindParam(3,$_POST['login']);
	$reqUpdate->execute();
	
	$email=NULL;
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT email FROM utilisateur WHERE login="'.$_POST['login'].'"');
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	foreach ($lignes as $colonne)
	{ 
		$email=$colonne->email;
	}	
	$resultats->closeCursor();	
		
		//**** Envoi mail avec le nouveau mdp*****
		require('mail/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->From = "contact@vivremegeve.fr";
		$mail->FromName = "Vivre Megève";
		$mail->Subject = "réinitialisation mot de passe";			 
		$body = "Bonjour,<br><br>


Voici votre nouveau mot de passe : ".$newMDPClair."<br>

Vous pouvez le modifier dès maintenant depuis votre interface client.<br>

Cordiales salutations.<br><br>

Vivre Megève";

		$mail->MsgHTML($body);
		//plusieurs destinataires = appeller plusieurs fois cette méthode
		$mail->AddAddress($email, "Client"." "."Nouveau MDP");
		$mail->send();
		//**** FIN Envoi mail confirmation client*****
		
		header ('Location: confirmationInformations.php');
} 
catch (InvalidSignatureException $e) 
{
    mail("reperret@hotmail.com","IPN Failed","The signature was invalid");
}

?>