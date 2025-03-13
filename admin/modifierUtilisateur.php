
<?php 
include '../connexion.php';
include 'verifAdmin.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Interface Administrateur</title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="css/layouts/side-menu.css">
    <!--<![endif]-->
</head>
<body>


<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>
	<?php
    include 'menu.php';
	
	
    ?>
    
    <?php 
$login=NULL;
$email=NULL;
$civilite=NULL;
$typeAdherent=NULL;
$numResident=NULL;
$nom=NULL;
$prenom=NULL;
$ddn=NULL;
$adresse=NULL;
$code_postal=NULL;
$ville=NULL;
$telephone=NULL;
    
$datePaiement=NULL;
$dateAdhesion=NULL;
$montantAdhesion=NULL;
$orderIdPaiement=NULL;
$typePaiement=NULL;
$paiement=NULL;
$renouvellement=NULL;

$sql='SELECT * FROM utilisateur where idUtilisateur='.$_GET['idToEdit'];
$resultats = $dbh->query('SET NAMES UTF8');
$resultats = $dbh->query($sql);
$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);

foreach ($lignes as $colonne)
{
	$login=$colonne->login;
	$email=$colonne->email;
	$civilite=$colonne->civilite;
	$typeAdherent=$colonne->typeAdherent;
	$numResident=$colonne->numResident;
	$nom=$colonne->nom;
	$prenom=$colonne->prenom;
	$ddn=$colonne->ddn;
	$adresse=$colonne->adresse;
	$code_postal=$colonne->code_postal;
	$ville=$colonne->ville;
    
	$datePaiement=$colonne->datePaiement;
    $dateAdhesion=$colonne->dateAdhesion;
    $montantAdhesion=$colonne->montantAdhesion;
    $orderIdPaiement=$colonne->orderIdPaiement;
    $typePaiement=$colonne->typePaiement;
    $paiement=$colonne->paiement;
    $renouvellement=$colonne->renouvellement;
    

    
    $telephone=$colonne->telephone;
}
	$resultats->closeCursor();
?>

    <div id="main">
        <div class="header">
            <h1>Utilisateur</h1>
            <h2>Informations personnelles</h2>
        </div>

	
        <div class="content">
          
           
           
           <form class="pure-form pure-form-stacked" action="updateUtilisateur.php" method="post">
    <fieldset>
   <br>
 <br>
 
        <?php $statut=NULL; if($paiement==1) { $statut="OK";} else{ echo "KO";} ?>
        <?php if($renouvellement==1) { $statut="A RENOUVELLER";} ?>
        Statut de l'utilisateur :   <strong><?php echo $statut ;?></strong><br><br>
 

    <label for="login">Login</label>
        <input id="login" name="login" type="text" value="<?php echo $login; ?>">
        
    <label for="nom">Nom</label>
        <input id="nom" name="nom" type="text" value="<?php echo $nom; ?>">
        
             <label for="prenom">Prénom</label>
        <input id="prenom" name="prenom" type="text" value="<?php echo $prenom; ?>">

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="<?php echo $email; ?>">

        <label for="civilite">Civilité</label>
        <select id="civilite" name="civilite">
            <option value="Monsieur" <?php if($civilite=="Monsieur") echo " selected"; ?>>Monsieur</option>
            <option value="Madame" <?php if($civilite=="Madame") echo " selected"; ?>>Madame</option>
        </select>
        
                <label for="ddn">Date de naissance</label>
        <input id="ddn" type="date" name="ddn" value="<?php echo $ddn; ?>">
        
                <label for="typeAdherent">Type adhérent</label>
        <select id="typeAdherent" name="typeAdherent">
            <option value="RP"  <?php if($typeAdherent=="RP") echo " selected"; ?>>RP</option>
            <option value="TS"  <?php if($typeAdherent=="TS") echo " selected"; ?>>TS</option>
            <option value="RS"  <?php if($typeAdherent=="RS") echo " selected"; ?>>RS</option>
            <option value="CP"  <?php if($typeAdherent=="CP") echo " selected"; ?>>CP</option>
        </select>
        
          <label for="numResident">Numéro résident</label>
        <input id="numResident" type="text" name="numResident" style="width:350px;" value="<?php echo $numResident; ?>">
        
         <label for="adresse">Adresse</label>
        <textarea rows="4" cols="20" name="adresse"><?php echo $adresse; ?></textarea>
        
        
         <label for="telephone">Téléphone</label>
        <input id="telephone" type="text" name="telephone" value="<?php echo $telephone; ?>">
        
         
         <label for="code_postal">Code postal</label>
        <input id="code_postal" type="text" name="code_postal" value="<?php echo $code_postal; ?>">
        
         
         <label for="ville">Ville</label>
        <input id="ville" type="text" name="ville" value="<?php echo $ville; ?>">


           
    
<input type="hidden" name="idUtilisateur" value="<?php echo $_GET['idToEdit'];?>"> 
        <button type="submit" class="pure-button pure-button-primary">Mettre à jour</button>
    </fieldset>
</form> 
            
            <br><br>
            
            <h1>Historique d'adhésion utilisateur</h1>
            
            <h2>Adhésion initiale</h2>
            
<table id="commentTable" class="dataTablesTable pure-table pure-table-bordered" >
    <thead>
        <tr id="theadRow">
        <th>Date paiement</th>
        <th>Date adhésion</th>
        <th>Montant adhésion </th>
        <th>Paiement Id Hello Asso</th>
        <th>Type Paiement</th>
        <th>Statut Paiement</th>
        <th>Détail paiement</th>
  </tr>
    </thead>
	
    <tbody>

    <tr>
    <td><?php echo $datePaiement; ?></td>
    <td><?php echo $dateAdhesion; ?></td>
    <td><?php echo $montantAdhesion; ?></td>
    <td><?php if($orderIdPaiement=="" || $orderIdPaiement==NULL) { echo $orderIdPaiement; } else{ echo "Non concerné";} ?></td>
    <td><?php echo $typePaiement ;?></td>
    <td><?php if($paiement==1) { echo "OK";} else{ echo "KO";}?></td>
    <td><?php if($orderIdPaiement!="" && $orderIdPaiement!=NULL) echo "<a href=\"detailPaiement.php?orderId=".$orderIdPaiement."\" target=\"_blank\">VOIR</a>" ;?></td>

    </tbody>
</table>
          

            
            <h2>Renouvellements</h2>
            
            <table id="commentTable" class="dataTablesTable pure-table pure-table-bordered" >
    <thead>
        <tr id="theadRow">
        <th>Justificatif PDF</th>
        <th>Montant</th>
        <th>Date </th>
        <th>Type Paiement</th>
        <th>Statut paiement</th>
        <th>Détail paiement</th>

  </tr>
    </thead>
	
    <tbody>

    <tr>
        
        <?php
            $sql='SELECT * FROM renouvellement where idUtilisateur='.$_GET['idToEdit'];
            $resultats = $dbh->query('SET NAMES UTF8');
            $resultats = $dbh->query($sql);
            $lignes=$resultats->fetchAll(PDO::FETCH_OBJ);

            foreach ($lignes as $colonne)
            {
                $urljustificatif=$colonne->urljustificatif;
                $montant=$colonne->montant;
                $date=$colonne->date;
                $typePaiementRenouvellement=$colonne->typePaiementRenouvellement;
                $paiement=$colonne->paiement;
                $orderIdRenouvellement=$colonne->orderIdRenouvellement;
                ?>
            <tr>
                    <td><a href="https://www.vivremegeve.fr/cartesGenerees/<?php echo $urljustificatif; ?>" target="_blank">Voir la carte PDF</a></td>
                    <td><?php echo $montant; ?></td>
                    <td><?php echo $date; ?></td>
                    <td><?php echo $typePaiementRenouvellement; ?></td>
                    <td><?php if($paiement==1) { echo "OK";} else{ echo "KO";}?></td>
                    <td><?php if($orderIdRenouvellement!="" && $orderIdRenouvellement!=NULL) echo "<a href=\"detailPaiement.php?orderId=".$orderIdRenouvellement."\" target=\"_blank\">VOIR</a>" ;?></td>
            </tr>
                <?php
            }
            $resultats->closeCursor();
            ?>
        

    </tbody>
</table>
            
            
          
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>
