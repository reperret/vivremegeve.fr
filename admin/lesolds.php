<?php 
include '../connexion.php';
include 'verifAdmin.php';

	if ($profilAdmin=="2") 
	{
		header ('Location: export.php');
		exit();
	} ?>
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

    <style>
        #petit {
            font-size: 0.7em;
        }

        .button-xsmall {
            font-size: 90%;
        }

        .button-success {
            background: rgb(28, 184, 65);
            /* this is a green */
        }

    </style>
</head>

<body>
    <script>
        function confirmerSuppression() {
            var x;
            if (confirm("CONFIRMER LA SUPPRESSION ?") == true) {
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

            </div>


            <div class="content">

                <center>
                    <?php if($_GET['c']==1)
		{ ?>
                    <h2 class="content-subhead">L'utilisateur a bien été supprimé</h2>
                    <?php } ?>




                    <div class="content">

                        <center>


                            <?php if($_GET['erreurCodeMairie']==1)
		{ ?>
                            <span style="color:red;font-weight:bold;font-size:2em;">ATTENTION LE CODE MAIRIE EST INVALIDE. VEUILLEZ RESSAYER</span>
                            <?php } ?>


                            <br><br><br>
                            <h2>Anciens comptes en attente de renouvellement</h2>

                            <div class="content">

                                <center>




                                    <?php 
               $annee=date('Y');
    $mois=date('m');
    $anneeSql=NULL;
    
    if($mois<9)
    {
        $anneeSql=$annee-2;    
    }
    else
    {
        $anneeSql=$annee-1;
    }
            $anneeSqlPlus1=$anneeSql+1;
          
	$sql=
"select * from utilisateur U where renouvellement=1 and paiement=1 

and not exists ( select * from renouvellement R where U.idUtilisateur=R.idUtilisateur and date between '".$anneeSql."-09-01' and '".$anneeSqlPlus1."-08-31')

and U.dateAdhesion < '".$anneeSql."-09-01'  

order by nom,prenom";
$resultats = $dbh->query('SET NAMES UTF8');
$resultats = $dbh->query($sql);
$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
?>
                                    <div id="petit">
                                        <a class="pure-button pure-button-primary" href="csv1.php?export=3">Export excel</a>
                                        <table id="commentTable" class="dataTablesTable pure-table pure-table-bordered">
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
                                                    <th>Date Adhésion</th>
                                                    <th>Modif.</th>
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
		if($colonne->renouvellement=="0")
		{
			?><button class="button-xsmall button-success pure-button">OK</button><?php
		}
		else
		{
			?>
                                                        <form class="pure-form" action="../payplug/renouvellementCheque.php?retour=lesolds" method="post">
                                                            <input type="text" name="codeMairie" required>
                                                            <input type="hidden" name="retourCodeMairieFaux" value="lesolds.php">
                                                            <input type="hidden" name="idUtilisateur" value="<?php echo $colonne->idUtilisateur; ?>">
                                                            <button type="submit" class="button-xsmall pure-button">RENOUVELER</button>
                                                        </form>


                                                        <?php
		}
		 
		
		
	}
	else
	{
		?>
                                                        <form class="pure-form" action="validationPaiement.php" method="post">
                                                            <input type="hidden" name="idUtilisateur" value="<?php echo $colonne->idUtilisateur; ?>">
                                                            <button type="submit" class="button-xsmall pure-button-primary">VALIDER</button>
                                                        </form>


                                                        <?php
	}
	
	
	
	?></td>
                                                    <td><?php echo $colonne->dateAdhesion; ?></td>

                                                    <td><a href="modifierUtilisateur.php?idToEdit=<?php echo $colonne->idUtilisateur; ?>"><img src="editerLOGO.png"></a></td>
                                                    <td><a href="supprimerUtilisateur.php?idUtilisateur=<?php echo $colonne->idUtilisateur; ?>" onclick="return confirmerSuppression()"><img src="supprimer.png"></a></td>
                                                </tr>
                                                <?Php
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
