<?php
//********DEBUT DE L'ENREGISTREMENT EN BASE D'UNE COMMANDE *********//
	include('../connexion.php');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

	session_start();
	
	
	//******VARIABLES RECUPEREES *************

	$idUtilisateur=$_POST['idU'];
	$nom=$_POST['nom'];
	$prenom=$_POST['prenom'];
	$email=$_POST['email'];
	

	
	//***************************************************************//
	//***************************************************************//
	//***************************************************************//
	//********REDIRECTION VERS LA PAGE PAYPLUG DE PAIEMENT *********//
	require_once("lib/Payplug.php");
	Payplug::setConfigFromFile("parameters.json");

	$paymentUrl = PaymentUrl::generateUrl(array(
										  'amount' => '1000',
										  'currency' => 'EUR',
										  'ipnUrl' => $domaine.'payplug/ipn.php',
										  'email' => $email, /* Your customer mail address */
										  'firstName' => $nom,
										  'lastName' => $prenom,
										  'order' => $idUtilisateur,
										  'returnUrl' => $domaine.'confirmation.php'
										  ));
	header("Location: $paymentUrl");
	exit();
	//********FIN DU SCRIPT PAYPLUG *********//
	//***************************************************************//
	//***************************************************************//
	//***************************************************************//

?>