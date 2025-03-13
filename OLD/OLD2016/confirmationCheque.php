
<?php 	session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<?php include 'meta.php'; ?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" type="image/x-icon" href="http://www.vivremegeve.fr/vivremegeve3/favicon.ico">
<script type="text/javascript" src="js/modernizr-2.7.1.js"></script>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  
<style type="text/css">

@media screen and (max-width: 1200px) 
{
	.div-dobule.x-2 
	{
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


<div class="w-section section features"><div class="arrow"><div class="arrow-2"></div></div>
	<div class="w-container">
		<div class="second-tittle white-2">
			<h3>MERCI</h3>
		</div>
	</div>
</div>

<div class="w-section section s-2">
	<div class="w-container">
		<div class="div-tittle">
			<h4> Pour finaliser votre inscription, veuillez envoyer un chèque de 10€ à l'ordre de "Association Vivre Megève" (sauf si vous ne l'avez pas déjà fait ou déposé en mairie), en précisant votre numéro d'adhérent suivant : <strong><?php echo $_GET['n']; ?></strong> à l'adresse suivante :</h4>
           
            
	
		</div>
        
         <div class="center">
		Association Vivre Megève<br>
        BP 23<br>
        1 place de l'Eglise 74120 MEGEVE
		</div>
		<br><br><br>
		<div class="center">
			En attendant, vous pouvez accéder à votre<a href="compteclient.php"> compte client</a>
		</div>
	</div>
</div>



	
	
	
	
</div>


          




<footer class="w-section footer"><div class="bottom-footer"><div class="w-container cont-center"><p class="p-footer">Création du site : <a href="http://www.remyperret.com" target="_blank">Rémy PERRET </a></p></div></div>
	
	<div class="w-container">
	
		<div class="w-row"><div class="w-col w-col-8 col-spc"><div><h1 class="top-footer">A propos de l'association</h1></div><div class="div-spc"><p><em><strong>Association</strong> de type loi "1901" crée à titre non lucratif avec pour objectif de représenter, défendre et informer ses membres en leur qualité d'usager des Services Publics Industriels et Commerciaux (SPIC)<br></em></p></div></div>
		
			
		
		<div class="w-col w-col-4"><div><h1 class="top-footer">Contact info</h1></div><div class="div-spc"><p> <strong>Email:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;contact@vivremegeve.fr<br><strong>Adresse:</strong>&nbsp;&nbsp;&nbsp;&nbsp;BP 23, 1 place de l'Eglise<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;74120 MEGEVE&nbsp;</p></div></div></div>
	
	</div>
	
	</footer>
  
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/webflow.a9732dd37.js"></script>
  <!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->

  
 </body>
 

 </html>
