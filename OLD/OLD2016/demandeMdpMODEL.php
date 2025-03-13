
<?php
try 
{
	include('connexion.php'); 
	session_start();	


?>

<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en-gb" class="no-js"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--[if lt IE 9]> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
	
	<title> DESK N' CO </title>
	
	<meta name="description" content="">
	<meta name="author" content="designthemes">
    
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
	<!--[if lte IE 8]>
		<script type="text/javascript" src="http://explorercanvas.googlecode.com/svn/trunk/excanvas.js"></script>
	<![endif]-->
    
    <!-- **Favicon** -->
	<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
    
    <!-- **CSS - stylesheets** -->
	<link id="default-css" href="style.css" rel="stylesheet" media="all" />
	<link href="css/animations.css" rel="stylesheet" media="all" />
    <link id="shortcodes-css" href="css/shortcodes.css" rel="stylesheet" type="text/css" />
    <link href="css/responsive.css" rel="stylesheet" type="text/css" />    
    <link href="css/meanmenu.css" rel="stylesheet" type="text/css" media="all" />
    
	<link href="css/funnyText.css" rel="stylesheet" type="text/css" />      
    
	<link href="css/isotope.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/prettyPhoto.css" rel="stylesheet" type="text/css" media="all" />
    
    <!-- **Skin - stylesheets** -->
	<link id="skin-css" href="skins/skyblue/style.css" rel="stylesheet" media="all" />
    
    <!-- **Font Awesome** -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="js/layerslider/css/layerslider.css" type="text/css">
    
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    
    
    
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/font-awesome-ie7.min.css" />
    <![endif]-->    
    
    <!-- **jQuery** -->
    <script src="js/modernizr-2.6.2.min.js"></script>
</head>

<body>
	

    <div class="wrapper">
        <div class="inner-wrapper">
	<!-- Header Starts here -->
              
<header id="header" class="type1 dt-sticky-menu">
                <div class="container">
                    <div id="logo">
                    <a href="index.php"> <img src="images/logo.png" alt="" title=""> </a>
                    </div>
                    <div id="menu-container" class="float-right">
                        <nav id="main-menu">
                            <ul class="group">
                                 <li class="menu-item"><a href="index.php#co-working" class="external">Co-Working</a> </li>
                                <li class="menu-item"><a href="index.php#offre" class="external">Offre</a></li>
                                <li class="menu-item"><a href="index.php#agenda" class="external">Agenda</a></li>
                                <li class="menu-item"><a href="index.php#quisommesnous" class="external">Qui sommes-nous</a></li>
                                <li class="menu-item"><a href="index.php#contact" class="external">Nous trouver</a></li>
                                <?php 	if (isset($_SESSION['login'])) 
								{ ?>
									 <li class="menu-item current_page_item"><a href="compteclient.php" class="external" >Mon compte</a></li>
									 <li class="menu-item"><a href="panier.php" class="external" >Mon panier</a></li>
								 <?php }
								else
								{ ?>
									
                                     <li class="menu-item current_page_item"><a href="espaceclient.php" class="external" >Espace client</a></li>
								<?php }
                      ?>
                            </ul>
                        </nav>
                    </div>         
                </div>
            </header>
			
			
            <!-- Header Ends here -->
            
            <div class="main">
            
                <div class="hr-invisible-very-small"></div>
                <div class="hr-invisible-very-small"></div>
            	
				<div class="container">
                 <center>
                 <h2>Mot de passe oublié</h2>
            
            
            <p>Veuillez rentrer votre pseudonyme de connexion (adresse email) pour recevoir votre nouveau mot de passe.</p>
			</center>
       <div id="centerPetit">
            <form class="pure-form pure-form-aligned" action="regenerateMdp.php" method="post">

    <fieldset>
     
        <input type="text" name="email"  placeholder="Email">

		 <button type="submit" class="pure-button pure-button-primary">Regénérer son mot de passe</button>
    </fieldset>
</form>
</div>
					


				</div>
				<div class="hr-invisible"> </div>
                <div class="hr-border-thin"> </div>
               
               
               	<section id="contact" class="content-fullwidth">
                    <footer id="footer">
                        <div class="copyright">
                           
                            
                           <p class="copyright-info"> Webmaster : Rémy Perret <a href="http://www.remyperret.com" target="_blank">www.remyperret.com </a> </p>
                        </div>
                    </footer>       
                </section>  
           </div> 
        </div>
    </div>
    
   <!-- Java Scripts -->
   
   
   
   
   
   
	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery-migrate.min.js"></script>
    <script type="text/javascript" src="js/jquery-easing-1.3.js"></script>
	<script type="text/javascript" src="js/plugins.min.js"></script>

    <script type="text/javascript" src="js/jquery.sticky.min.js"></script>    
    <script type="text/javascript" src="js/jquery.nav.min.js"></script>
    <script type="text/javascript" src="js/jquery.menu.min.js"></script>
    <script type="text/javascript" src="js/jquery.meanmenu.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.totop.min.js"></script>
    
    <script type="text/javascript" src="js/jquery.scrollTo.min.js"></script>
    

    
    <script type="text/javascript" src="js/jquery.parallax.min.js"></script>
    
    <script type="text/javascript" src="js/jquery.carouFredSel-6.2.1-packed.js"></script>
    <script type="text/javascript" src="js/twitter/jquery.tweet.min.js"></script>
    

    
    <script src="js/scrollplugins/ScrollToPlugin.min.js" type="text/javascript"></script>
    <script src="js/scrollplugins/smoothPageScroll.js" type="text/javascript"></script>
	<script src="js/scrollplugins/greensock.js" type="text/javascript"></script> 
    
	<script src="js/jquery.funnyText.min.js"></script>
    <script src="js/wow.min.js"></script>
    
	
    
    <script src="js/custom.js"></script>    
    
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