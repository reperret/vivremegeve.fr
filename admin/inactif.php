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


                    <?php if($_GET['erreurCodeMairie']==1)
		{ ?>
                    <span style="color:red;font-weight:bold;font-size:2em;">ATTENTION LE CODE MAIRIE EST INVALIDE. VEUILLEZ RESSAYER</span>
                    <?php } ?>



                    <h2>Nouvelles inscriptions en attente de validation</h2>

                    <div class="content">

                        <center>




                            <?php 
            
       $annee=date('Y');
            $finannee=$annee+1;
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
            
            
            
            
	$sql="select * from utilisateur U where (U.paiement=0 or U.paiement IS NULL) and U.dateAdhesion between '".$annee."-09-01' and '".$finannee."-08-31 order by nom, prenom";
            	$sql="select * from utilisateur U where (U.paiement=0 or U.paiement IS NULL)  order by nom, prenom";
$resultats = $dbh->query('SET NAMES UTF8');
$resultats = $dbh->query($sql);
$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
?>
                            <div id="petit">

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
                                            <th>Type Paiement</th>
                                            <th>Date Adhésion</th>
                                            <th>Modif</th>
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
	

		?>
                                                <form class="pure-form" action="validationPaiement.php" method="post">
                                                    <input type="hidden" name="idUtilisateur" value="<?php echo $colonne->idUtilisateur; ?>">
                                                    <button type="submit" class="button-xsmall pure-button-primary">VALIDER</button>
                                                </form>


                                            </td>
                                            <td>
                                                <form method="post" action="updateTypePaiement.php">
                                                    <select id="changementTypePaiement" name="changementTypePaiement" style="width:100px" onchange="javascript:  if (confirm('CONFIRMER LE CHANGEMENT ?') == true) {
       this.form.submit();
        return true;
    } else {
    if(document.getElementById('changementTypePaiement').value=='cb')
    {
    	document.getElementById('changementTypePaiement').value = 'cheque';
    }
    else
    {
    	document.getElementById('changementTypePaiement').value = 'cb';

    }
    	
       return false;
    } ">
                                                        <option value="cheque" <?php if($colonne->typePaiement=="cheque") echo "selected" ?>>cheque</option>
                                                        <option value="cb" <?php if($colonne->typePaiement=="cb") echo "selected" ?>>cb</option>
                                                    </select>
                                                    <input type="hidden" name="idUtilisateur" value="<?php echo $colonne->idUtilisateur; ?>">
                                                </form>
                                                <?php 
	
	 
	
	?>
                                            </td>
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

                            <br><br><br>
                            <h2>Anciens comptes en attente de renouvellement</h2>
                            <a class="pure-button pure-button-primary" href="csv1.php?export=2">Export excel</a> <a class="pure-button pure-button-primary" href="csvMailjet.php?prec=1">Fichiers contact TXT Mailjet à renouveler</a>
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
          
	
$sql="select * from utilisateur U where renouvellement=1 and paiement=1 and

(

exists
(
select * from renouvellement R where U.idUtilisateur=R.idUtilisateur and R.date between '".$anneeSql."-09-01' and '".$anneeSqlPlus1."-08-31' 
) 

or (U.datePaiement  between '".$anneeSql."-09-01' and '".$anneeSqlPlus1."-08-31'  and paiement=1) 

) order by nom, prenom ";
             
$resultats = $dbh->query('SET NAMES UTF8');
$resultats = $dbh->query($sql);
$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
?>
                                    <div id="petit">
                                        <table id="commentTable" class="dataTablesTable pure-table pure-table-bordered">
                                            <thead>
                                                <tr id="theadRow">
                                                    <th>N°Adherent </th>
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
                                                    <td>
                                                        <form class="pure-form" action="../payplug/renouvellementCheque.php?retour=inactif" method="post">
                                                            <input type="hidden" name="idUtilisateur" value="<?php echo $colonne->idUtilisateur; ?>">
                                                            <input type="hidden" name="retourCodeMairieFaux" value="inactif.php">

                                                            <input type="text" name="codeMairie" required>
                                                            <button type="submit" class="button-xsmall pure-button">RENOUVELER</button>
                                                        </form>

                                                    </td>
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
