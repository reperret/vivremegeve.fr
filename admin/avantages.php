<?php 
include '../connexion.php';
include 'verifAdmin.php';


if(isset($_GET['idD']) &&  $_GET['idD']!='')
{
    $reqUpdate = $dbh->prepare("UPDATE document set avantagesEnCours=0");
    $reqUpdate->execute();
    
    
    $reqUpdate = $dbh->prepare("UPDATE document set avantagesEnCours=1 where idDocument=?");
    $reqUpdate->bindParam(1, $_GET['idD']);
    $reqUpdate->execute();
}

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
            background: rgb(28, 184, 65);
            /* this is a green */
        }

        .button-error {
            background: rgb(202, 60, 60);
            /* this is a maroon */
        }

        .button-warning {
            background: rgb(223, 117, 20);
            /* this is an orange */
        }

        .button-secondary {
            background: rgb(66, 184, 221);
            /* this is a light blue */
        }

        .reference {
            color: green;
            font-weight: bold;
            font-size: 1.5em;
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
                <h1>Documents</h1>
                <h2>Définir le document référence pour les avantages</h2>
            </div>


            <div class="content">


                <table class="pure-table">
                    <thead>
                        <tr>
                            <th>Document</th>
                            <th>Définir comme référence</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
         //******************** RECUPERATION INFORMATION CLIENT ************************
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * from document order by idDocument desc');
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	$flash=NULL;
	foreach ($lignes as $colonne)
	{ 
        ?>
                        <tr>
                            <td><?php echo $colonne->titreDocument;?></td>
                            <td>
                                <?php
                                if($colonne->avantagesEnCours ==  1)
                                {
                                      ?> <span class="reference">Le bouton en page d'accueil pointe vers ce document</span><?php
                                  
                                }
                                else
                                {
                                  ?> <a href="avantages.php?idD=<?php echo $colonne->idDocument;?>" class="button-warning pure-button">DEFINIR COMME DOCUMENT REFERENCE</a><?php
                                }
                                ?>

                            </td>
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
