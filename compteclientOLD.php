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
$codeMairie=NULL;

	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT paiement, typePaiement, prenom, idUtilisateur, codeMairie From utilisateur WHERE login LIKE "'.$_SESSION['login'].'"');
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
 
	foreach ($lignes as $colonne)
	{
		$paiement=$colonne->paiement;
		$typePaiement=$colonne->typePaiement;	
		$prenom=$colonne->prenom;	
		$idUtilisateur=$colonne->idUtilisateur;	
        $codeMairie=$colonne->codeMairie;	
	}	
	$resultats->closeCursor();
	
?>




<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Association Vivre Megève</title>



<link rel="stylesheet" type="text/css" href="css/style.css">
<link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" type="image/x-icon" href="http://www.vivremegeve.fr/vivremegeve3/favicon.ico">
<script type="text/javascript" src="js/modernizr-2.7.1.js"></script>
  
<style type="text/css">
    
    .grand{font-size: 2.2em; color: #ea0079;}
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
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
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
    
  
<table class="pure-table pure-table-bordered" style="width:70%">
    <thead>
        
    </thead>

    <tbody>
    
  
	<?php
	
	$numAdherent=NULL;
 	
	foreach ($lignes as $colonne)
	{ 
		
	?>
	<tr>
	  <td style="background-color:#333334; color:#FFF; font-weight:bold">Etat de votre compte</td>
        
        <!-- AVANT MISE EN PROD 1ER SEPTEMBRE 
        <td style="background-color:#F00; font-size:1.2em; text-align:left">
             <p class="blancGras">Renouvellement ouvert à partir du 1er septembre 2021</p>
         </td>
         FIN AVANT MISE EN PROD 1ER SEPTEMBRE -->
        
        
      <?php
	  $renouvellement=$colonne->renouvellement;
        

        
      
	  if($colonne->renouvellement==1)
	  { 
          $anneeEnCours = new DateTime();        
        ?>
		 <td style="background-color:#F00; font-size:1.2em; text-align:left">
         <p class="blancGras">Votre compte doit être renouvelé</p>
          
            <!-- <span style="background-color: #C0C0C0;">PAIEMENT PAR CB MOMENTANEMENT INDISPONIBLE</span> -->
             
    
             
             Pour régler par Carte Bancaire les <?php echo $montantAnneeEnCours; ?>€ de votre cotisation, rentrez votre code de sécurité fourni par la mairie puis cliquez sur "RENOUVELER" :<br>
             
             <?php if(isset($_GET['codeMairie']) && $_GET['codeMairie']==0 )
        {
            ?><span style="background-color: yellow; font-weight:bold; font-size:1.3em">[ ! ] CE CODE DE SECURITE N'EST PAS VALIDE, VEUILLEZ RECOMMENCER</span><?php
        }
             
          ?>
             
             
           <form class="pure-form" method="post" action="payplug/paiementAdhesion.php">
               <input type="text" name="codeMairie" placeholder="Code sécurité mairie" required>
                    <input type="hidden" name="idU" value="<?php echo $idUtilisateur; ?>">
                    <input type="hidden" name="nom" value="<?php echo $colonne->nom; ?>">
                    <input type="hidden" name="prenom" value="<?php echo $colonne->prenom; ?>">
                    <input type="hidden" name="email" value="<?php echo $colonne->email; ?>">
                    <input type="hidden" name="adresse" value="<?php echo $colonne->adresse; ?>">
                    <input type="hidden" name="code_postal" value="<?php echo $colonne->code_postal; ?>">
                    <input type="hidden" name="ddn" value="<?php echo $colonne->ddn; ?>">
                    <input type="hidden" name="r" value="1">
                    <button type="submit" class="pure-button">RENOUVELER</button>
                    </form>


           
         <br><br>Sinon envoyez un chèque de <?php echo $montantAnneeEnCours; ?>€ à l'adresse :<br>
         		<strong> Association Vivre Megève<br>
                Tour MAGDELAIN<br>
                28, place de l'église<br>
                74120 MEGEVE <br>
                </strong>
             
               <br>
               Veuillez dans cet envoi préciser votre numéro d'adhérent :<strong> <?php echo $colonne->numAdherent; ?> </strong> ainsi que le code de sécurité  fourni par la mairie
         </td>
       <?php   
	  }
	  else
	   { 
	   if($paiement==1)
		{ ?>
	 
		 <td style="background-color:#0C0; font-size:1.2em" >Votre cotisation est à jour</td> 
	    <?php  
		}
		else
		{
			?> <td style="background-color:#FC0; font-size:1.2em" >Votre paiement n'est pas à jour<br><a href="payplug/paiementAdhesion.php?idU=<?php echo $idUtilisateur;?>&nom=<?php echo $colonne->nom;?>&prenom=<?php echo $colonne->prenom;?>&email=<?php echo $colonne->email;?>&codeMairieGet=<?php echo $colonne->codeMairie;?>" >Payer maintenant</a></td> <?php
		}
	  }
      
      
	  ?>
	 
	  </tr>
	<tr>
		<td style="background-color:#ea0079; color:#FFF; font-weight:bold">N° adhérent Vivre Megève</td>
        <td><strong><span class="grand"><?php $numAdherent=$colonne->numAdherent; echo $colonne->numAdherent; ?></span></strong></td>  
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
    case "CP":
        echo "Commerçant permanant";
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
  <br><br>
  <br><br>
  <br><br>      
        
           <div class="div-tittle">
			<h4>Votre historique d'<span class="color">adhésion</span></h4>
		</div>
        
             
  <table class="pure-table pure-table-bordered">
    <thead>
        <tr>
            <th>Date Achat</th>
            <th>Date Expiration</th>
            <th>Objet</th>
            <th>Montant</th>
            <th>Justificatif</th>
        </tr>
    </thead>

    <tbody>
		
      <?php 
	  $dernierJustificatif=NULL;
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * from utilisateur WHERE idUtilisateur='.$idUtilisateur);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	
    
 	foreach ($lignes as $colonne)
	{ 
	?>
		 <tr>
            <td>            
            <?php 
			$datee = new DateTime($colonne->dateAdhesion);
			echo $datee->format('d/m/Y');
            $dateExpiration=NULL;
			if($datee->format('m')<9)
            {
                $dateExpiration=$datee->format('Y')."-08-31";
            }
            else
            {
                $dateExpiration=($datee->format('Y')+1)."-08-31";;
            }
                ?>
            </td>
            <td><?php $datee = new DateTime($dateExpiration);
			echo $datee->format('d/m/Y');?></td>
            <td>Adhésion initiale</td>
            <td><?php echo $colonne->montantAdhesion; ?>€</td>
            <td>
            
            <?php
			if($paiement==1)
		{ ?>
		 <a href="<?php echo $dernierJustificatif=$domaine.'cartesGenerees/'.$colonne->urlCarte; ?>" target="_blank">Téléchargement</a>
        <?php
		}
		else
		{
		   echo "En attente de réception du paiement";	
		}
           ?>
            
            
            </td>
        </tr>    <?php
	
	
	}	
	$resultats->closeCursor(); 
	  
      
      
	
	$resultats2 = $dbh->query('SET NAMES UTF8');
	$resultats2 = $dbh->query('SELECT * from renouvellement WHERE idUtilisateur='.$idUtilisateur.' order by date');
	$lignes2=$resultats2->fetchAll(PDO::FETCH_OBJ);
	
    
 	foreach ($lignes2 as $colonne2)
	{ 
	?>
		 <tr>
            <td><?php 
            $datee = new DateTime($colonne2->date);
            $mois=$datee->format('n');
            $anneeExpiration=NULL;
            $periodeAdhesion=NULL;
            if($mois<9)
            {
                $anneeExpiration=$datee->format('Y');
                $periodeAdhesion=($datee->format('Y')-1)."/".$datee->format('Y'); 
            }
            else
            {
                $anneeExpiration=$datee->format('Y')+1;
                $periodeAdhesion=$datee->format('Y')."/".($datee->format('Y')+1); 
            }
        
            echo $datee->format('d/m/Y'); ?></td>
            <td>
             <?php
        $datee = new DateTime($colonne2->date);
            $dateExpiration=NULL;
			if($datee->format('n')<9)
            {
                $dateExpiration=$datee->format('Y')."-08-31";
            }
            else
            {
                $dateExpiration=($datee->format('Y')+1)."-08-31";;
            }
         $datee = new DateTime($dateExpiration);
			echo $datee->format('d/m/Y');;
        ?>
             </td>
            <td>Renouvellement 
                <?php 
               
                echo $periodeAdhesion;
                ?>
            </td>
            <td><?php echo $colonne2->montant; ?>€</td>
            <td><a href="<?php echo $dernierJustificatif=$domaine.'cartesGenerees/'.$colonne2->urljustificatif; ?>" target="_blank">Téléchargement</a></td>
        </tr>    <?php
	
	
	}	
	$resultats2->closeCursor(); 
	  ?> 
        

      
	 
			
    </tbody>
</table>

 

     <br><br> <br><br> 
        
        
        
     <br><br> <br><br>  
        
        
        <div class="div-tittle">
			<h4>Votre  <span class="color">JUSTIFICATIF </span>   d'adhésion EN COURS</h4>
		</div>  
        <?php
	
			
		if($paiement==1)
		{
		
			if($renouvellement==0 )
			{?>     
               <a href="<?php echo $dernierJustificatif; ?>" target="_blank"> <img src="images/telechargerVotreCarte.png"></a>
                 <?php
			}
			else
			{
				?>Votre compte doit être renouvelé. Veuillez suivre s'il vous plait les instructions en haut de cette page dans l'encadré rouge.<?php
			}
			
			
		}
		else
		{ 
			if($typePaiement=="cheque")
			{ ?>
				Votre justificatif sera disponible une fois votre chèque encaissé. Pour rappel, ce chèque de <strong><?php echo $montantAnneeEnCours; ?>€</strong> à l'ordre de "Association Vivre Megève" doit être envoyé à l'adresse suivante :<br><br>
                
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
					Votre justificatif sera disponible une fois votre paiement reçu. Vous avez choisi de régler par Carte Bancaire, vous pouvez dès maintenant finaliser votre inscription en réglant ici la somme de <?php echo $montantAnneeEnCours; ?>€ en ligne :<br><br>
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
		
			
		
		<div class="w-col w-col-4"><div><h1 class="top-footer">Contact info</h1></div><div class="div-spc"><p> <strong>Email:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;contact@vivremegeve.fr<br><strong>Adresse:</strong>&nbsp;&nbsp;&nbsp;&nbsp;Tour MAGDELAIN, 28, place de l'église <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;74120 MEGEVE&nbsp;</p></div></div></div>
	
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
