<?php
try 
{
	include('connexion.php'); 
	session_start();	

//**************VERIFICATION ADMIN DEBUT**********************
if (!isset($_SESSION['login'])) 
{
	header ('Location: seconnecter.php');
	exit();
}

$prenom="";
$idUtilisateur=NULL;
$paiement=NULL;
$typePaiement=NULL;

	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT paiement, typePaiement, prenom, idUtilisateur From utilisateur WHERE login LIKE "'.$_SESSION['login'].'"');
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
 
	foreach ($lignes as $colonne)
	{
		$paiement=$colonne->paiement;
		$typePaiement=$colonne->typePaiement;	
		$prenom=$colonne->prenom;	
		$idUtilisateur=$colonne->idUtilisateur;	
	}	
	$resultats->closeCursor();
	
?>




<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Association Vivre Megève</title>



<link rel="stylesheet" type="text/css" href="css/style.css">
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" type="image/x-icon" href="http://www.vivremegeve.fr/vivremegeve3/favicon.ico">
<script type="text/javascript" src="js/modernizr-2.7.1.js"></script>
  
<style type="text/css">
table{
		margin:auto;
	}
@media screen and (max-width: 1200px) 
{
	.div-dobule.x-2 
	{
		padding-right: 100px;
	}
}
	
</style>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
  
<body>

<div class="w-nav navigation" data-collapse="medium" data-animation="default" data-duration="400" data-contain="1">
	<div class="w-container sns-container">
		<a class="w-nav-brand brand" href="index.php">
		<img class="logo" src="images/logo.png" width="200" alt="logo.png">
		</a>
	  
		 <?php include 'menu.php'; ?>
			
		<div class="w-nav-button hamburger">
			<div class="w-icon-nav-menu"></div>
		</div>
	</div>
</div>

<div class="w-section section gray">



<div class="w-section section features"><div class="arrow"><div class="arrow-2"></div></div>
	<div class="w-container">
		<div class="second-tittle white-2">
			<h3><?php echo $prenom; ?>, voici un résumé de votre compte (<a href="deconnexion.php">deconnexion</a>)</h3>
		</div>
	</div>
</div>


<div class="w-section section s-2">
        <div class="w-container">
        
        
        <div class="div-tittle">
			<h4>Vos informations  <span class="color">personnelles</span></h4>
		</div>
		
	<div class="center">
	  
 <?php
 
	$nom=NULL;
	$prenom=NULL;
	$email=NULL;
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * from utilisateur WHERE idUtilisateur='.$idUtilisateur);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	
	?>
    
  
<table class="pure-table pure-table-bordered" style="width:50%">
    <thead>
        
    </thead>

    <tbody>
    
  
	<?php
	
	$numAdherent=NULL;
 	
	foreach ($lignes as $colonne)
	{ 
		
	?>
	<tr>
		<td style="background-color:#333334; color:#FFF; font-weight:bold">N° adhérent</td>
        <td><strong><?php $numAdherent=$colonne->numAdherent; echo $colonne->numAdherent; ?></strong></td>  
	</tr>	
     <tr>
		<td style="background-color:#333334; color:#FFF; font-weight:bold">N° carte résident</td>
        <td><strong><?php echo $colonne->numResident; ?></strong></td>  
	</tr>	
    
	 <tr>
		<td style="background-color:#333334; color:#FFF; font-weight:bold">Votre statut</td>
        <td><?php 
		
		switch ($colonne->typeAdherent) {
    case "RP":
        echo "Résident permanent";
        break;
    case "RS":
        echo "Résident secondaire";
        break;
    case "TS":
        echo "Travailleur/Saisonnier";
        break;
}
		?></td>  
	</tr>
        
    <tr>
		<td style="background-color:#333334; color:#FFF; font-weight:bold">Civilité</td>
        <td><?php echo $colonne->civilite; ?></td>  
	</tr>	
    <tr>	
		<td style="background-color:#333334; color:#FFF; font-weight:bold">Nom</td>
        <td><?php echo $nom=$colonne->nom; ?></td>  
    </tr>
    <tr>
		<td style="background-color:#333334; color:#FFF; font-weight:bold">Prénom</td>
        <td><?php echo $prenom=$colonne->prenom; ?></td>  
	</tr>
    
    <tr>
		<td style="background-color:#333334; color:#FFF; font-weight:bold">Date de naissance</td>
        <td><?php 
		$date = new DateTime($colonne->ddn);
		echo $date->format('d/m/Y');
		
		?></td>  
	</tr>
    
     <tr>
		<td style="background-color:#333334; color:#FFF; font-weight:bold">Paiement</td>
        <td><?php 
		if($colonne->typePaiement=="cb")
		{
			echo "Carte Bancaire";
		}
		else
		{
			echo "Chèque"; 	
		}
		
		?></td>  
	</tr>

    <tr>
		<td style="background-color:#333334; color:#FFF; font-weight:bold">Email</td>
        <td><?php echo $email=$colonne->email; ?></td>  
	</tr>
   
    <tr>
		<td style="background-color:#333334; color:#FFF; font-weight:bold">Téléphone</td>
        <td style="width:30%"><?php echo $colonne->telephone; ?></td>  
	</tr>
      <tr>
		<td style="background-color:#333334; color:#FFF; font-weight:bold; width:20%">Adresse</td>
        <td style="width:30%"><?php echo $colonne->adresse." "; ?><?php echo $colonne->code_postal." "; ?><?php echo $colonne->ville; ?></td>  
	</tr>
	
    
    <?php
	
	
	}	
	$resultats->closeCursor(); ?>
					
	 
            
      
	 
			
    </tbody>				
		

</table>  
<br><br>
        <a class="pure-button" href="compteclientModification.php">MODIFIER VOS INFORMATIONS</a> 
     <br><br> <br><br>  
        
        
        <div class="div-tittle">
			<h4>Votre <span class="color">justificatif</span>  d'adhésion</h4>
		</div>  
        <?php
		if($paiement=="1")
		{
		?>
       <a href="generationCarteAdherent.php?idU=<?php echo $idUtilisateur; ?>" target="_blank"> <img src="images/telechargerVotreCarte.png"></a>
         <?php
		}
		else
		{ 
			if($typePaiement=="cheque")
			{ ?>
				Votre justificatif sera disponible une fois votre chèque encaissé. Pour rappel, ce chèque de <strong>10€</strong> à l'ordre de "Association Vivre Megève" doit être envoyé à l'adresse suivante :<br><br>
                
                Association Vivre Megève<br>
                Tour MAGDELAIN<br>
                28, place de l'église<br>
                74120 MEGEVE <br>
                
             
               <br>
               Veuillez dans cet envoi préciser votre numéro d'adhérent :<strong> <?php echo $numAdherent; ?></strong>
            
			<?php 
			}
			else
			{ ?>
					Votre justificatif sera disponible une fois votre paiement reçu. Vous avez choisi de régler par Carte Bancaire, vous pouvez dès maintenant finaliser votre inscription en réglant ici la somme de 10€ en ligne :<br><br>
                    <form class="pure-form" method="post" action="payplug/paiementAdhesion2.php">
                    <input type="hidden" name="idU" value="<?php echo $idUtilisateur; ?>">
                    <input type="hidden" name="nom" value="<?php echo $nom; ?>">
                    <input type="hidden" name="prenom" value="<?php echo $prenom; ?>">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <button type="submit" class="pure-button pure-button-primary">REGLER L'INSCRIPTION</button>
                    </form>
			<?php 
			
			}
		}
		?>
         
	</div>
</div>
</div>

</div>




<footer class="w-section footer"><div class="bottom-footer"><div class="w-container cont-center"><p class="p-footer">Création du site : <a href="http://www.remyperret.com" target="_blank">Rémy PERRET </a></p></div></div>
	
	<div class="w-container">
	
		<div class="w-row"><div class="w-col w-col-8 col-spc"><div><h1 class="top-footer">A propos de l'association</h1></div><div class="div-spc"><p><em><strong>Association</strong> de type loi "1901" crée à titre non lucratif avec pour objectif de représenter, défendre et informer ses membres en leur qualité d'usager des Services Publics Industriels et Commerciaux (SPIC)<br></em></p></div></div>
		
			
		
		<div class="w-col w-col-4"><div><h1 class="top-footer">Contact info</h1></div><div class="div-spc"><p> <strong>Email:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;contact@vivremegeve.fr<br><strong>Adresse:</strong>&nbsp;&nbsp;&nbsp;&nbsp;BP 23, 1 place de l'Eglise<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;74120 MEGEVE&nbsp;</p></div></div></div>
	
	</div>
	
	</footer>
  
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/webflow.a9732dd37.js"></script>
  <!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->

  
 </body>
 

 </html>
 
 
<?php 
}	
catch(Exception $e)
{
  $dbh->rollBack();
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
