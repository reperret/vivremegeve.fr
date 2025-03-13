<?php
$input = file_get_contents('php://input');
include '../connexion.php';
include('../generationCarteAdherentFonction.php');


//**************RECUPERATION DES ELEMENTS HELLO ASSO**************
$dataPaiementHello=json_decode($input,true);
$idUtilisateur=$dataPaiementHello['metadata']['idUtilisateur'];
$nom = $dataPaiementHello['metadata']['nomUtilisateur'];
$prenom = $dataPaiementHello['metadata']['prenomUtilisateur'];
$email = $dataPaiementHello['metadata']['emailUtilisateur'];
$codeRecupere = $dataPaiementHello['metadata']['codeMairie'];
$renouvellement=$dataPaiementHello['metadata']['renouvellement'];

$payment_id=$dataPaiementHello['data']['order']['id'];
$orderId=$dataPaiementHello['data']['id'];
$payment_date=$dataPaiementHello['data']['date'];

$eventState=$dataPaiementHello['data']['state'];
$eventType=$dataPaiementHello['eventType'];
$itemState=$dataPaiementHello['data']['items'][0]['state'];
$logPaiementEvent=$eventType." ".$eventState." ".$itemState;

$idRenouvellement=NULL;



//****************ON LOGUE LE JSON RECU ET POUR EVITER DOUBLON************************
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$reqInsert = $dbh->prepare("INSERT INTO logPaiement (logPaiementContenu,logPaiementIdHello,logPaiementEvent,logPaiementDateReellePaiement, logPaiementOrderId) VALUES (?,?,?,?,?)");
$reqInsert->bindParam(1, $input);
$reqInsert->bindParam(2, $payment_id);
$reqInsert->bindParam(3, $logPaiementEvent);
$reqInsert->bindParam(4, $payment_date);
$reqInsert->bindParam(5, $orderId);

$reqInsert->execute();


//****************SI PAIEMENT OK************************
if($eventType=='Payment' && $eventState=='Authorized' && $itemState=='Processed')
{

    //******************** RECUPERATION INFORMATION CLIENT ************************
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query('SELECT * from utilisateur WHERE idUtilisateur='.$idUtilisateur);
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

    //****************VERIFICATION RENOUVELLEMENT OU NON********************************
    if($renouvellement==1)
    {
        //***************** Génération de la carte PDF  ***********************
        $urlCarte=generateCarteUtilisateur($idUtilisateur,'',$numAdherent, $dbh);

        //******************** MISE A JOUR CHAMP PAIEMENT************************
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $reqUpdate = $dbh->prepare("UPDATE utilisateur SET renouvellement=0 WHERE idUtilisateur=?");
        $reqUpdate->bindParam(1,$idUtilisateur);
        $reqUpdate->execute();
        
        
        
        $dateRenouvellement = new DateTime();
        $dateRenouvellement=$dateRenouvellement->format('Y-m-d H:i:s');
        $montantAnneeEnCours=intval($montantAnneeEnCours);
        $un=intval("1");

        $reqInsert = $dbh->prepare("INSERT INTO renouvellement (transactionRenouvellement,date,idUtilisateur,montant,urljustificatif, paiement,orderIdRenouvellement, codeMairie) VALUES (?, ?, ? ,? ,? ,?, ?,?)");        					
        $reqInsert->bindParam(1,$payment_id);
        $reqInsert->bindParam(2,$dateRenouvellement);
        $reqInsert->bindParam(3,$idUtilisateur);
        $reqInsert->bindParam(4,$montantAnneeEnCours);
        $reqInsert->bindParam(5,$urlCarte);
        $reqInsert->bindParam(6,$un);
        $reqInsert->bindParam(7,$orderId);
        $reqInsert->bindParam(8,$codeRecupere);
        $reqInsert->execute();
        $idRenouvellement=$dbh->lastInsertId();


    }
    else
    {
        //******************** MISE A JOUR CHAMP PAIEMENT************************
        $dateUp=date("Y-m-d H:i:s");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $reqUpdate = $dbh->prepare("UPDATE utilisateur SET paiement=1, transactionPaiement=? , datePaiement=?, orderIdPaiement=? WHERE idUtilisateur=?");
        $reqUpdate->bindParam(1,$payment_id); 
        $reqUpdate->bindParam(2,$dateUp);
        $reqUpdate->bindParam(3,$orderId);
        $reqUpdate->bindParam(4,$idUtilisateur);
        $reqUpdate->execute();

    }



    //***********MISE A JOUR CODE MAIRIE ********************
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $reqUpdate = $dbh->prepare("UPDATE code set dateUtilisationCode=?, idUtilisateur=?, idRenouvellement=?  where valeurCode=?");
    $reqUpdate->bindParam(1,$dateUtilisationCode); 
    $reqUpdate->bindParam(2,$idUtilisateur);
    $reqUpdate->bindParam(3,$idRenouvellement);
    $reqUpdate->bindParam(4,$codeRecupere);
    $dateUtilisationCode=date('Y-m-d H:i:s');
    $reqUpdate->execute();


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
    //$mail->AddAddress($emailWebmasterAlerte, "SEM");
    $mail->AddAddress($emailAlerteSem, "SEM");

    $mail->send();


}

?>
