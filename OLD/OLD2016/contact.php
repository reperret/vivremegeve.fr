<?php 	session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Association Vivre Megève</title>

<link rel="stylesheet" type="text/css" href="css/style.css">
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" type="image/x-icon" href="http://www.vivremegeve.fr/vivremegeve3/favicon.ico">
<script type="text/javascript" src="js/modernizr-2.7.1.js"></script>
  
<style type="text/css">

@media screen and (max-width: 1200px) 
{
	.div-dobule.x-2 
	{
		padding-right: 100px;
	}
}
	
</style>
<script src='https://www.google.com/recaptcha/api.js'></script>
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


<div class="w-nav-button hamburger"><div class="w-icon-nav-menu"></div></div></div></div>



<div class="w-section section gray">


<div class="w-section section features"><div class="arrow"><div class="arrow-2"></div></div>
	<div class="w-container">
		<div class="second-tittle white-2">
			<h3>N'hésitez pas à nous contacter</h3>
		</div>
	</div>
</div>



<div class="w-section section gray">


<div class="w-container">

<?php 
if(isset($_GET['c']) && $_GET['c']=="1")
{
?>
<div class="div-tittle">
			<h4>Votre message nous a bien été <span class="color">transmis</span></h4>
		</div>

<?php 
}
?>
<div class="w-form">

<form class="w-clearfix" id="email-form" name="email-form" data-name="Email Form" action="contactPost.php" method="post">

<input class="w-input text-filed" id="name" type="text" placeholder="Nom" name="nom" data-name="Name" required>
<input class="w-input text-filed no-l" id="name" type="text" placeholder="Prénom" name="prenom" data-name="Name" required>
<input class="w-input text-filed" id="Email-2" type="email" placeholder="Adresse email" name="email" data-name="Email" required>

<input class="w-input text-filed no-l" id="Subjet" type="text" placeholder="Téléphone" name="telephone" data-name="Subjet">

<textarea class="w-input text-filed _100-p are" id="Area" placeholder="Votre message" name="message" data-name="Area" required></textarea>*

<div class="g-recaptcha" data-sitekey="6LdC8hcTAAAAALai9tRHxOpbruUt41_BElgMm3aX"></div>

<input class="w-button button sub" type="submit" value="ENVOYER" data-wait="Veuillez patienter...">



</form><div class="w-form-done success"><p class="form-mess">Merci. Votre message nous a bien été transmis.</p></div><div class="w-form-fail success err"><p class="form-mess">Une erreur est survenu. Veuillez retenter l'opération</p></div></div></div></div>






<div class="map"><div class="w-widget w-widget-map" data-widget-latlng="45.857171, 6.618043" data-widget-style="terrain" data-widget-zoom="16" data-disable-scroll="1"></div></div></div>



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
