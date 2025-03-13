
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
     
        <th>idutilisateur</th>
        <th>N°CarteRésid.</th>
        <th>N°CarteRésid Correct</th>
        <th>Nom Prénom</th>
        <th>Erreur</th>
   
   
  </tr>
    </thead>
	
    <tbody>
<?php    
	foreach ($lignes as $colonne)
	{
		$nettoyage="";
		
		?>
    	
    <tr>
    <td><?php echo $colonne->idUtilisateur; ?></td>
    <td><?php echo $nettoyage=str_replace(" ","",str_replace( "-", "", $colonne->numResident));  ?></td>
	<td><?php
    	
		if(strlen($nettoyage)==23)
		{
			
				$part1=substr($nettoyage, 0, 2);
	$part2=substr($nettoyage, 2, 20);
	$part3=substr($nettoyage, -1, 1);
	echo $part1."-".$part2."-".$part3;
		}

	
	
	?></td>
    
    
    
    <td><?php echo $colonne->nom." ".$colonne->prenom; ?></td>
	<td><?php
	if(strlen($nettoyage)!=23)
	{
		echo strlen($nettoyage);	
	}
	
	?></td>
	
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
