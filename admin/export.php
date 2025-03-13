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
                <h1>Export fichier Utilisateurs</h1>
                <h2>Format Excel</h2>
            </div>


            <div class="content">
                <h2 class="content-subhead">Télécharger l'ensemble des adhérents à jour de leurs cotisations</h2>
                <p>
                    <a class="pure-button pure-button-primary" href="csv1.php?export=1">Fichier complet</a>
                </p>


            </div>


            <div class="content">
                <h2 class="content-subhead">En attente de renouvellement</h2>
                <p>
                    <a class="pure-button pure-button-primary" href="csv1.php?export=2">Fichier 2016/2017</a>
                </p>


            </div>

            <div class="content">
                <h2 class="content-subhead">Télécharger l'ensemble des adhérents inactifs</h2>
                <p>
                    <a class="pure-button pure-button-primary" href="csv1.php?export=3">Fichier des inactifs</a>
                </p>


            </div>
        </div>
    </div>

    <script src="js/ui.js"></script>

</body>

</html>
