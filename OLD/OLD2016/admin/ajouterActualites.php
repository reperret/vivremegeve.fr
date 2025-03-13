
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
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
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
            <h1>Actualités</h1>
            <h2>Nouvelle actualité</h2>
        </div>

	
        <div class="content">

           <form class="pure-form" action="insertActualite.php" method="post">

    <fieldset class="pure-group">
        <input type="text" name="titre" class="pure-input-1" placeholder="Titre de l'actualité">
        <textarea class="pure-input-1" name="contenu" placeholder="Contenu de l'actualité" rows="12"></textarea>
    </fieldset>

    <button type="submit" class="pure-button pure-input-1 pure-button-primary">AJOUTER</button>
</form>
            
             
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>
