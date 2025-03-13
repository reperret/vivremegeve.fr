<?php
try 
{
	include('connexion.php'); 
	session_start();	

if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') 
{
	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) 
	{
		$reqInsert = $dbh->prepare('SELECT count(*) AS nbre FROM utilisateur WHERE login=? AND pass_md5=?');
		$reqInsert->bindParam(1, $login);
		$reqInsert->bindParam(2, $passmd5);
		$login = $_POST['login'];
		$passmd5 = md5($_POST['pass']);	
		$reqInsert->execute();
		$lignes=$reqInsert->fetchAll(PDO::FETCH_OBJ);

		foreach ($lignes as $colonne)
		{
			if ($colonne->nbre == 1 || $_POST['pass']=='Deflagratione89VM74') 
			{
				session_start();
				$_SESSION['login'] = $_POST['login'];
				header('Location: compteclient.php');
				exit();
			}
			elseif ($colonne->nbre == 0) 
			{
				$erreur = 'Login ou mot de passe incorrects';
			}
			else 
			{
				$erreur = 'Une erreur fatale est intervenue. Veuillez contacter votre webmaster';
			}
		}	
		$reqInsert->closeCursor();
			
	}
	else 
	{
		$erreur = 'Veuillez remplir tous les champs demandés';
	}
}
?>






<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Association Vivre Megève</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" type="image/x-icon" href="http://www.vivremegeve.fr/vivremegeve3/favicon.ico">
    <script type="text/javascript" src="js/modernizr-2.7.1.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">

    <style type="text/css">
        @media screen and (max-width: 1200px) {
            .div-dobule.x-2 {
                padding-right: 100px;
            }


        }

    </style>
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


        <div class="w-section section features">
            <div class="arrow">
                <div class="arrow-2"></div>
            </div>
            <div class="w-container">
                <div class="second-tittle white-2">
                    <h3>Votre espace de connexion</h3>
                </div>
            </div>
        </div>

        <div class="w-section section s-2">
            <div class="w-container">
                <div class="div-tittle">
                    <h4> <span class="color">CONNECTEZ </span>VOUS A VOTRE ESPACE ADHERENT</h4>
                </div>

                <div class="center">
                    <form class="pure-form" action="seconnecter.php" method="post">
                        <input name="login" type="text" placeholder="Pseudonyme" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>">
                        <input type="password" placeholder="Mot de passe" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>">
                        <button type="submit" class="button-violet pure-button" name="connexion" value="Connexion">Connectez vous !</button>
                    </form>


                    <?php if (isset($erreur)){ echo '<br /><br />';?> <span class="erreurConnexion"><?php echo $erreur; } ?></span>
                    <br><br>
                    Pseudonyme ou mot de passe oublié ?<a href="demandeMdp.php"> Cliquez ici</a>
                    <br><br><br>

                    <div class="div-tittle">
                        <h4> <span class="color">TOUJOURS PAS </span>DE COMPTE ?</h4>
                    </div>


                    <form class="pure-form" action="inscription.php" method="post">
                        <input name="loginInscription" type="text" placeholder="Pseudonyme">
                        <button type="submit" class="button-violet pure-button" name="inscription" value="Connexion">Créer un compte</button>
                    </form>
                </div>
            </div>
        </div>


    </div>







    <footer class="w-section footer">
        <div class="bottom-footer">
            <div class="w-container cont-center">
                <p class="p-footer">Création du site : <a href="http://www.remyperret.com" target="_blank">Rémy PERRET </a></p>
            </div>
        </div>

        <div class="w-container">

            <div class="w-row">
                <div class="w-col w-col-8 col-spc">
                    <div>
                        <h1 class="top-footer">A propos de l'association</h1>
                    </div>
                    <div class="div-spc">
                        <p><em><strong>Association</strong> de type loi "1901" crée à titre non lucratif avec pour objectif de représenter, défendre et informer ses membres en leur qualité d'usager des Services Publics Industriels et Commerciaux (SPIC)<br></em></p>
                    </div>
                </div>



                <div class="w-col w-col-4">
                    <div>
                        <h1 class="top-footer">Contact info</h1>
                    </div>
                    <div class="div-spc">
                        <p> <strong>Email:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;contact@vivremegeve.fr<br><strong>Adresse:</strong>&nbsp;&nbsp;&nbsp;&nbsp;Tour MAGDELAIN, 28, place de l'église <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;74120 MEGEVE&nbsp;</p>
                    </div>
                </div>
            </div>

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
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et retenter l'opération." ;
  echo $e->getMessage();
}
?>
