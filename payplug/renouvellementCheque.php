<?php

include('../connexion.php'); 


try 
{	 
    
    $redirect='Location: ../admin/index.php';
    
    
    $codeRecupere=trim(strtoupper($_POST['codeMairie']));
    $codeMairie=false;
    $codeMairie=verifierCodeMairie($codeRecupere,$dbh);
    
    if($codeMairie)
    {
        
   
    echo "TEST1";
    //******************** RECUPERATION INFORMATION CLIENT ************************
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * from utilisateur WHERE idUtilisateur='.$_POST['idUtilisateur']);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	$ddn=NULL;
	$dateAdhesion=NULL;
	$numResident=NULL;
	$numAdherent=NULL;
	$typeAdherent=NULL;

	$nom=NULL;
	$prenom=NULL;
	$email=NULL;
	foreach ($lignes as $colonne)
	{ 
		$ddn=$colonne->ddn;
		$dateAdhesion=$colonne->date;
		$numResident=$colonne->numResident;
		$numAdherent=$colonne->numAdherent;
		$typeAdherent=$colonne->typeAdherent;
		$nom=$colonne->nom;
		$prenom=$colonne->prenom;
		$email=$colonne->email;
	}	
	$resultats->closeCursor();	
    
    
        
        echo "TEST2";
	//******************** RECUPERATION URL CARTE FIN************************

	//**** Génération de la carte PDF  ****
	include('../generationCarteAdherentFonction.php');
	$urlCarte=generateCarteUtilisateur($_POST['idUtilisateur'],'',$numAdherent, $dbh);
	//**** FIN Génération de la carte PDF + numéro adhérent ****
	

echo "TEST3";
	//******************** MISE A JOUR CHAMP PAIEMENT************************
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$reqUpdate = $dbh->prepare("UPDATE utilisateur SET renouvellement=0 WHERE idUtilisateur=?");
	$reqUpdate->bindParam(1,$_POST['idUtilisateur']);
	$reqUpdate->execute();
	//******************** FIN MISE A JOUR CHAMP PAIEMENT************************
    

	echo "TEST4";
	$typePaiement="cheque";
    $idU=intval($_POST['idUtilisateur']);
    $montantAnneeEnCours=intval($montantAnneeEnCours);
    $un=intval("1");
    $dateRenouvellement = new DateTime();
    $dateRe=$dateRenouvellement->format('Y-m-d H:i:s');
    echo $dateRe;
        
    $reqInsert = $dbh->prepare("INSERT INTO renouvellement (date,idUtilisateur,montant,urljustificatif,paiement,typePaiementRenouvellement,codeMairie) VALUES (?,?,?,?,?,?,?)");			
    $reqInsert->bindParam(1,$dateRe);
    $reqInsert->bindParam(2,$idU);
    $reqInsert->bindParam(3,$montantAnneeEnCours);
    $reqInsert->bindParam(4,$urlCarte);
    $reqInsert->bindParam(5,$un);
    $reqInsert->bindParam(6,$typePaiement);
    $reqInsert->bindParam(7,$codeRecupere);
    $reqInsert->execute();
    $idRenouvellement=$dbh->lastInsertId();

        echo "TEST5";
            
    //***********MISE A JOUR CODE ********************
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $reqUpdate = $dbh->prepare("UPDATE code set dateUtilisationCode=?, idUtilisateur=?, idRenouvellement=? where valeurCode=?");
    $reqUpdate->bindParam(1,$dateUtilisationCode); 
    $reqUpdate->bindParam(2,$idUtilisateur);
    $reqUpdate->bindParam(3,$idRenouvellement); 
    $reqUpdate->bindParam(4,$codeRecupere);
    $dateUtilisationCode=date('Y-m-d H:i:s');
    $reqUpdate->execute();
    //**********FIN MISE A JOUR CODE ********************

echo "TEST6";
	
	
	
	//******************** ENVOI MAIL ************************

	require('../mail/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->From = "contact@vivremegeve.fr";
	$mail->FromName = "Vivre Megève";
	$mail->Subject = "confirmation renouvellement";						 
	$body = "Bonjour ".$prenom." ".$nom."<br><br>
	
Nous vous remercions pour votre renouvellement. Vous êtes à nouveau adhérent à l'association Vivre Megève pour une année supplémentaire.<br><br>

Vous pouvez dès maintenant récupérer votre nouvelle carte d'adhérent sur votre Espace client en cliquant ci dessous ou en pièce jointe à ce mail.<br><br>

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
    
    else
    {
        $redirect='Location: ../admin/'.$_POST['retourCodeMairieFaux'].'?erreurCodeMairie=1';
    }
	header($redirect);
	exit();
} 
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}

?>
