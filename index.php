<?php
session_start();
include('connexion.php');
$resultats = $dbh->query('SET NAMES UTF8');
$resultats = $dbh->query('SELECT * from document where avantagesEnCours=1');
$lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
$flash = NULL;
$lienAvantages = "actualites/";
foreach ($lignes as $colonne) {
    $lienAvantages .= $colonne->nomDocument;
}
$resultats->closeCursor();
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
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css"
        integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <script type="text/javascript" src="js/modernizr-2.7.1.js"></script>

    <style type="text/css">
    .button-avantages {
        background: rgb(28, 184, 65);
        font-size: 1.3em;
        color: white;
        font-weight: bold
            /* this is a green */
    }



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



    <?php

    try {

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->query("SET NAMES 'utf8'");
        $sql = 'SELECT * FROM parametre where idParametre=1';
        $resultats = $dbh->query($sql);
        $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);

        foreach ($lignes as $colonne) {
            $activationFlash = $colonne->valueParametre;
        }
    } catch (Exception $e) {
        //$dbh->rollBack();
        echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération.";
        echo $e->getMessage();
    }

    if ($activationFlash == "1") {



        try {

            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $dbh->query("SET NAMES 'utf8'");
            $sql = 'SELECT * FROM flash where idFlash=(SELECT max(idFlash) FROM flash)';
            $resultats = $dbh->query($sql);
            $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);

            foreach ($lignes as $colonne) {
                $contenu = $colonne->infoFlash;
                $datePublication = $colonne->dateFlash;
                $date = new DateTime($datePublication);
            }
        } catch (Exception $e) {
            //$dbh->rollBack();
            echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération.";
            echo $e->getMessage();
        }



    ?>



    <?php } ?>










    <div class="w-hidden-medium w-hidden-small w-hidden-tiny sns-shrink"></div>

    <div class="w-section section features">
        <div class="arrow">
            <div class="arrow-2">
            </div>
        </div>
        <div class="w-container">
            <div class="second-tittle white-2" style="text-transform : none">


                <div id="DivClignotante" style="visibility:visible;">
                    <h2>FLASH INFO - <?php echo $date->format('d/m/Y'); ?> </h2>
                </div>
                <script type="text/javascript">
                var clignotement = function() {
                    if (document.getElementById('DivClignotante').style.visibility == 'visible') {
                        document.getElementById('DivClignotante').style.visibility = 'hidden';
                    } else {
                        document.getElementById('DivClignotante').style.visibility = 'visible';
                    }
                };
                // mise en place de l appel de la fonction toutes les 0.8 secondes 
                // Pour arrêter le clignotement : clearInterval(periode); 
                periode = setInterval(clignotement, 700);
                </script>



                <br>
                <?php echo $contenu; ?>
            </div>


        </div>
    </div>

    <div class="w-section banner">
        <div class="w-container con-baner">
            <div class="sub-banner">
                <div class="w-hidden-tiny" data-ix="zom-out">Pour mieux vivre dans notre village !</div>
            </div>
            <div class="div-tittle header" data-ix="from-bottom">
                <h3>Adhérer à l'association VIVRE <span class="lighter _2">Megève</span></h3>
            </div>
            <div class="div-spc ceb">
                <a class="button" href="inscription.php" data-ix="zom-out-2">Adhérer</a>
                <a class="button btn-color cl-2" href="compteclient.php" data-ix="zom-out-3">Renouveler</a>
            </div>

        </div>

    </div>




    <div class="w-section section s-2">
        <div class="w-container">
            <div class="div-tittle">
                <h3> <span class="color">POURQUOI </span>ADHEREZ A L'ASSOCIATION ?</h3>
                <br><br>
                <a href="<?php echo $lienAvantages; ?>" class="button-avantages pure-button" target="_blank">VOIR LES
                    AVANTAGES</a>
            </div>
            <div class="center">
                <h2>L'adhésion à l'association Vivre Megève couplée à la Carte de Résident délivrée par la municipalité
                    permet d'obtenir de nombreuses remises tarifaires. C'est notamment le cas pour :</h2>
            </div>
            <br><br>

            <div class="w-row">
                <div class="w-col w-col-6">
                    <div class="service-wrapper">
                        <img src="images/remontees.jpg">
                        <h4>Les remontées mécaniques</h4>


                    </div>
                </div>


                <div class="w-col w-col-6">
                    <div class="service-wrapper">
                        <img src="images/megeveParking.jpg">


                    </div>


                </div>

            </div>
            <br><br><br>


            <div class="w-row">






                <div class="w-col w-col-12">
                    <div class="service-wrapper">
                        <img src="images/tunnelMB.jpg">
                        <h4>Tunnel du Mont Blanc*</h4>

                    </div>


                </div>

            </div>

            <br><br><br>
            <div class="w-row">



                <div class="w-col w-col-6">
                    <div class="service-wrapper">
                        <img src="images/pds.jpg">
                        <h4>Le Palais*</h4>

                    </div>


                </div>


                <div class="w-col w-col-6">
                    <div class="service-wrapper">
                        <img src="images/luge.jpg">
                        <h4>Luge 4 saisons...*</h4>

                    </div>


                </div>

            </div>

            <br><br>
            <center>

                Retrouvez le tableau complet des avantages : <br>


                <a href="<?php echo $lienAvantages; ?>" class="button-avantages pure-button" target="_blank">VOIR TOUS
                    LES AVANTAGES</a>
                <br><br>

                <h2> Pour connaitre les modalités d'utilisation des réductions ci dessus appelez l'association au 06 03
                    26 38 54</h2>
            </center>




        </div>
    </div>
    </div>
    </div>









    <hr>

    <center>
        <h2>&nbsp;</h2>
    </center>
    <div class="w-section section gray">
        <div class="w-container">
            <div class="div-tittle">
                <h3><span class="color">QUAND ET COMMENT</span> ADHERER A L'ASSOCIATION ?</h3>
            </div>
            <div class="center">

                <h3>Adhésion 100% en ligne à tout moment. La validité d'une carte s'étend du 1er septembre au 31 août.
                    Très simplement, <a href="inscription.php">inscrivez vous</a> sur notre site
                    <u>www.vivremegeve.fr</u>, <u>muni obligatoirement</u> de votre carte de résident délivrée par la
                    Mairie et réglez la somme de <u><?php echo $montantAnneeEnCours; ?>€</u>
                </h3>
            </div>
        </div>


        <br><br>

        <div class="w-container">
            <div class="div-tittle">
                <h3><span class="color">QUAND ET COMMENT</span> RENOUVELER MA COTISATION ?</h3>
            </div>
            <div class="center">

                <h3>Vous êtes déjà inscrit sur le site, vous accédez uniquement à votre <a
                        href="compteclient.php">compte client</a> et vous vous laissez guider par la procédure, qui
                    consiste à payer en ligne la nouvelle cotisation de <?php echo $montantAnneeEnCours; ?>€ ou envoyer
                    un chèque de <?php echo $montantAnneeEnCours; ?>€ à l'association Vivre Megève</h3>
            </div>
        </div>

    </div>







    <footer class="w-section footer">
        <div class="bottom-footer">
            <div class="w-container cont-center">
                <p class="p-footer">Création du site : <a href="http://www.remyperret.com" target="_blank">Rémy PERRET
                    </a></p>
            </div>
        </div>

        <div class="w-container">

            <div class="w-row">
                <div class="w-col w-col-8 col-spc">
                    <div>
                        <h1 class="top-footer">A propos de l'association</h1>
                    </div>
                    <div class="div-spc">
                        <p><em><strong>Association</strong> de type loi "1901" crée à titre non lucratif avec pour
                                objectif de représenter, défendre et informer ses membres en leur qualité d'usager des
                                Services Publics Industriels et Commerciaux (SPIC)<br></em></p>
                    </div>
                </div>



                <div class="w-col w-col-4">
                    <div>
                        <h1 class="top-footer">Contact info</h1>
                    </div>
                    <div class="div-spc">
                        <p><strong>Téléphone:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0603263854<br>
                        <p><strong>Email:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;contact@vivremegeve.fr<br><strong>Adresse:</strong>&nbsp;&nbsp;&nbsp;&nbsp;Tour
                            MAGDELAIN, 28, place de l'église
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;74120
                            MEGEVE&nbsp;</p>
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
<script src="javascript/goose.js"></script>