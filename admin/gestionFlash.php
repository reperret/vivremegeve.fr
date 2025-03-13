
<?php 
include '../connexion.php';
include 'verifAdmin.php';

 //******************** RECUPERATION INFORMATION CLIENT ************************
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * from flash order by dateFlash desc limit 1');
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	$flash=NULL;
	foreach ($lignes as $colonne)
	{ 
		$flash=$colonne->infoFlash;
	}	
	$resultats->closeCursor();	
    

?>
<!doctype html>
<html lang="en">
<head>
       
    <!-- Include stylesheet -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
    <style scoped>

        .button-success,
        .button-error,
        .button-warning,
        .button-secondary {
            color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }

        .button-success {
            background: rgb(28, 184, 65); /* this is a green */
        }

        .button-error {
            background: rgb(202, 60, 60); /* this is a maroon */
        }

        .button-warning {
            background: rgb(223, 117, 20); /* this is an orange */
        }

        .button-secondary {
            background: rgb(66, 184, 221); /* this is a light blue */
        }

    </style>
    
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
            <h1>Flash Info</h1>
            <h2>Gestion</h2>
        </div>

	
        <div class="content">
        
        <?php 
try 
{


	$activationFlash=NULL;

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$dbh->query("SET NAMES 'utf8'");
	$sql = 'SELECT * FROM parametre where idParametre=1';
	$resultats = $dbh->query($sql);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
			
	foreach ($lignes as $colonne)
	{	
		$activationFlash=$colonne->valueParametre;
	}
		


		

		
		if($activationFlash=="0")
		{?>
			<a href="updateActivationFlash.php?param=1" class="button-success pure-button">Activer flash info</a>	<?php
		}
		else
		{
			?>
			 <a href="updateActivationFlash.php?param=0" class="button-error pure-button">Désactiver flash info</a><?php
		}
		
        
   
    
   }	
catch(Exception $e)
{
  //$dbh->rollBack();
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
    ?>
    
    
    

           <form class="pure-form" action="insertFlash.php" method="post">

    <fieldset class="pure-group">
        <textarea class="pure-input-1" name="contenu" placeholder="Contenu du flash" rows="12"><?php echo $flash;?></textarea>
    </fieldset>
    
    
    
    
    

    
    
    
    
    

    <button type="submit" class="pure-button pure-input-1 pure-button-primary">MODIFIER</button>
</form>
            
             
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>
