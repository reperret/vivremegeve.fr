<?php
try 
{
	include('../connexion.php');
	include('verifConnexion.php');
?>

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
</head>
<body>


    <div id="main">
        <div class="header">
             <img src="../images/logoMail.jpg">
        </div>

	
        <div class="content">
        	<center>
            <h2 class="content-subhead">Interface d'administration</h2>
          	</center>
            
              <?php if (isset($erreur)) echo '',$erreur; ?>


            <form class="pure-form pure-form-stacked" action="authentification.php" method="post">
                <select name="login" class="pure-input-1" required>         
                <?php 	   
                    $resultats = $dbh->query('SELECT login From administrateur');
                    $lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
                    foreach ($lignes as $colonne)
                    {
                        if (isset($_POST['email']) && $colonne->email==$_POST['email'])
                        {
                            echo '<option value="'.$colonne->login.'" selected>'.$colonne->login.'</option>';
                
                        }
                        else
                        {
                            echo '<option value="'.$colonne->login.'">'.$colonne->login.'</option>';
                        }
                    }	
                    $resultats->closeCursor();   
                ?>      
                </select>
                
                <input type="password" class="pure-input-1" placeholder="Mot de passe" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>">
                <button type="submit" name="connexion" value="Connexion" class="pure-button button-violet pure-input-1">Se connecter</button>
            </form>
             
             
             
             
             
        </div>
    </div>


<script src="js/ui.js"></script>

</body>
</html>

<?php 
}	
catch(Exception $e)
{
	echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
	echo $e->getMessage();
}
?>
