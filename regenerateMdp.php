<?php
try
{
	include('connexion.php');  
        
	$newMDPClair=uniqid();
	$newMDP=md5($newMDPClair);
	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	$reqUpdate = $dbh->prepare("UPDATE utilisateur SET pass_md5=? WHERE login=?");
	$reqUpdate->bindParam(1,$newMDP); 
	$reqUpdate->bindParam(2,$_POST['login']);
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
    
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	$reqUpdate = $dbh->prepare("INSERT INTO logmdp SET passClair=?, dateNewMdp=?, emailEnvoi=?, login=?");
	$reqUpdate->bindParam(1,$newMDPClair); 
	$reqUpdate->bindParam(2,date("Y-m-d H:i:s")); 
    $reqUpdate->bindParam(3,$email); 
	$reqUpdate->bindParam(4,$_POST['login']);
	$reqUpdate->execute();
		
    $emailDestinataire=$email;
    $emailExpediteur="contact@vivremegeve.fr";
    $nomExpediteur="Vivre Megeve";
    $numeroTemplate="6";
    $tag_titre="Nouveau mot de passe";
    $tag_contenu="Bonjour,<br><br>
    
    Voici votre nouveau mot de passe : ".$newMDPClair."<br>
    Vous pouvez le modifier dès maintenant depuis votre interface adhérent.<br>
    Cordiales salutations.<br><br>
    
    Vivre Megève";
    $tag_lienbouton="https://vivremegeve.fr/seconnecter.php";
    $tag_libellebouton="SE CONNECTER";
    $sujet="votre nouveau mot de passe";
    
    echo sendMail($emailDestinataire, $tag_titre, $tag_contenu, $tag_libellebouton, $tag_lienbouton, "6330280", $sujet, NULL);

    
    
		
		header ('Location: confirmationInformations.php');
} 
catch (InvalidSignatureException $e) 
{
	die("Impossible de se connecter: " . $e->getMessage());
}

?>
