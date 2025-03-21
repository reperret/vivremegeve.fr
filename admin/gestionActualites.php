
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

    <div id="main">
        <div class="header">
            <h1>Gestion des actualités</h1>
            <h2>Listing</h2>
        </div>

	
   <div class="content">
<h2 class="content-subhead">Toutes les actualités</h2>
            
            
            <?php 
$sql='SELECT * FROM actualite ORDER BY datePublication DESC';
$resultats = $dbh->query('SET NAMES UTF8');
$resultats = $dbh->query($sql);
$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
?>


<table class="pure-table pure-table-bordered" >
    <thead>
        <tr>
<th>Titre</th>
<th>Texte</th>
<th>PJ</th>
<th>Date</th>
<th>Actions</th>



  </tr>
    </thead>
	
    <tbody>
<?php    
	foreach ($lignes as $colonne)
	{?>
    <tr>
		<td><?php echo stripslashes($colonne->titre); ?></td>
        <td><?php echo stripslashes($colonne->contenu); ?></td>
        <td><?php 
     
    $sql='SELECT * FROM document where idActualite='.$colonne->idActualite;
    $resultats2 = $dbh->query('SET NAMES UTF8');
    $resultats2 = $dbh->query($sql);
    $lignes2=$resultats2->fetchAll(PDO::FETCH_OBJ);
     foreach ($lignes2 as $colonne2)
	 {
       ?><a href="../actualites/<?php echo $colonne2->nomDocument?>" target="_blank"><?php echo $colonne2->titreDocument?></a><br><?php
     }
?>
        </td>
        <td><?php echo $colonne->datePublication; ?></td>
        
		<td><a href ="modifierActualite.php?idToEdit=<?php echo $colonne->idActualite; ?>"><img src="editerLOGO.png"></a><a href ="supprimerActualite.php?idToDelete=<?php echo $colonne->idActualite; ?>"><img src="deleteLOGO.png"></a>
		
       
        <?php if(utf8_encode($colonne->publication)=="0"){?><img src="nonpubliee.png"><?php }else{?><img src="publiee.png"><?php }; ?></td>
	</tr><?Php
	}	
	$resultats->closeCursor();
       
        
?>
    </tbody>
</table>
            <br><center>
            <a class="pure-button pure-button-primary" href="ajouterActualites.php">Ajouter une Actualité</a></center>
        
  
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>
