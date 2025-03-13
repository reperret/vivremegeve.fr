
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
$titre=NULL;
$contenu=NULL;
$sql='SELECT * FROM actualite where idActualite='.$_GET['idToEdit'];
$resultats = $dbh->query('SET NAMES UTF8');
$resultats = $dbh->query($sql);
$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);

foreach ($lignes as $colonne)
{
	$titre=$colonne->titre;
	$contenu=$colonne->contenu;	
}
	$resultats->closeCursor();
?>

    <div id="main">
        <div class="header">
            <h1>Actualités</h1>
            <h2>Nouvelle actualité</h2>
        </div>

	
        <div class="content">
            
            <h2>Pièces jointes actuelles</h2>
                      <?php 
     
    $sql='SELECT * FROM document where idActualite='.$_GET['idToEdit'];
    $resultats2 = $dbh->query('SET NAMES UTF8');
    $resultats2 = $dbh->query($sql);
    $lignes2=$resultats2->fetchAll(PDO::FETCH_OBJ);
     foreach ($lignes2 as $colonne2)
	 {
       ?>--> <a href="../actualites/<?php echo $colonne2->nomDocument; ?>" target="_blank"><?php echo $colonne2->titreDocument?></a> <a href="deleteDocument.php?idDocument=<?php echo $colonne2->idDocument;?>">(supprimer)</a><br><?php
     }
?>
       <br><br>     
            

           <form class="pure-form" action="updateActualite.php" method="post">

    <fieldset class="pure-group">
        <input type="text" name="titre" class="pure-input-1" placeholder="Titre de l'actualité" value="<?php echo $titre; ?>">
        <textarea class="pure-input-1" name="contenu" placeholder="Contenu de l'actualité" rows="12"><?php echo $contenu; ?></textarea>
    </fieldset>

               
               
                <h2>Ajout Pièces jointes</h2>
                         <table class="pure-table pure-table-horizontal">
    <thead>
        <tr>
            <th>Titre document</th>
            <th>Fichier</th>

        </tr>
    </thead>

    <tbody>
        <tr>
            <td><input type="text" name="titre1" class="pure-input-1" placeholder="Titre PJ1"></td>
            <td><input type="file" name="pj1" id="pj1"></td>
        </tr>
        
          <tr>
              <td><input type="text" name="titre2" class="pure-input-1" placeholder="Titre PJ2"></td>
            <td><input type="file" name="pj2" id="pj2"></td>
        </tr>
        
          <tr>
              <td><input type="text" name="titre3" class="pure-input-1" placeholder="Titre PJ3"></td>
            <td> <input type="file" name="pj3" id="pj3"></td>
        </tr>
        
          <tr>
              <td><input type="text" name="titre4" class="pure-input-1" placeholder="Titre PJ4"></td>
            <td>  <input type="file" name="pj4" id="pj4"></td>
        </tr>
        
          <tr>
              <td><input type="text" name="titre5" class="pure-input-1" placeholder="Titre PJ5"></td>
            <td><input type="file" name="pj5" id="pj5"></td>
        </tr>


    </tbody>
</table>
               <br><br>      
               
               
               
               
               
               
               
               
               
               
               
	<input type="hidden" name="idActualite" value="<?php echo $_GET['idToEdit'];?>"> 
    <button type="submit" class="pure-button pure-input-1 pure-button-primary">METTRE A JOUR</button>
               
               
               
               
               
               
</form>
            
            
  
            
            
             
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>
