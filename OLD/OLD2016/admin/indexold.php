
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
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="css/layouts/side-menu.css">
    <!--<![endif]-->
    
    <style>
	#petit{
		font-size:	0.7em;
	}
	
	.button-xsmall {
            font-size: 90%;
        }
		
		.button-success {
            background: rgb(28, 184, 65); /* this is a green */
        }
	</style>
</head>
<body>
<script>
function confirmerSuppression() {
    var x;
    if (confirm("CONFIRMER LA SUPPRESION ?") == true) {
        return true;
    } else {
       return false;
    }
}
</script>

<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>
	<?php
    include 'menu.php';
    ?>

    <div id="main">
        <div class="header">
            <h1>Adhérent Vivre Megève</h1>
            <h2>Listing complet</h2>
        </div>

	
        <div class="content">
        
        <center>
        <?php if($_GET['c']==1)
		{ ?>
			        <h2 class="content-subhead">L'utilisateur a bien été supprimé</h2>
		<?php } ?>
    
    
            
             <?php 
	$sql=
"SELECT * from utilisateur";
$resultats = $dbh->query('SET NAMES UTF8');
$resultats = $dbh->query($sql);
$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
?>
<div id="petit">
<table id="commentTable" class="dataTablesTable pure-table pure-table-bordered" >
    <thead>
        <tr id="theadRow">
     
        <th>N°Adherent</th>
        <th>N°CarteRésid.</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>DDN</th>
        <th>Email</th>
        <th>Statut</th>
        <th>Tel</th>
        <th>Paiement</th> 
        <th>Type Paiement</th> 
        <th>Date Adhésion</th>        
		<th>Suppr</th>
   
  </tr>
    </thead>
	
    <tbody>
<?php    
	foreach ($lignes as $colonne)
	{?>
    <tr>
    <td><?php echo $colonne->numAdherent; ?></td>
    <td><?php echo $colonne->numResident; ?></td>
    <td><?php echo $colonne->nom; ?></td>
    <td><?php echo $colonne->prenom; ?></td>
    <td><?php echo $colonne->ddn; ?></td>
    <td><?php echo $colonne->email; ?></td>
    <td><?php echo $colonne->typeAdherent; ?></td>
	<td><?php echo $colonne->telephone; ?></td>
	<td><?php 
	
	if($colonne->paiement=="1")
	{
		?><button class="button-xsmall button-success pure-button">OK</button><?php 
	}
	else
	{
		?>    
        <form class="pure-form" action="validationPaiement.php" method="post">
       		<input type="hidden" name="idUtilisateur" value="<?php echo $colonne->idUtilisateur; ?>">
			<button type="submit" class="button-xsmall pure-button">VALIDER</button>
		</form>
        
        
        <?php
	}
	
	
	
	?></td>
    <td><?php echo $colonne->typePaiement; ?></td>
    <td><?php echo $colonne->dateAdhesion; ?></td>
         <td><a href="supprimerUtilisateur.php?idUtilisateur=<?php echo $colonne->idUtilisateur; ?>" onclick="return confirmerSuppression()"><img src="supprimer.png"></a></td>
        </tr><?Php
	}	
	$resultats->closeCursor();
       
        
?>
    </tbody>
</table>
            
            </div>
            
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>
