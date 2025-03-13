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
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">

<!-- AVATAR-->
    <link href="assets/css/croppic.css" rel="stylesheet">
  
<style type="text/css">

@media screen and (max-width: 1200px) 
{
	.div-dobule.x-2 
	{
		padding-right: 100px;
	}
}

#cadreNews{
width:55%;
text-align:justify;	
margin:auto;
}

.hp {
    display: none;
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
			<h3>Les dernières actualités de l'association</h3>
		</div>
	</div>
</div>

<div class="w-section section s-2">
	<div class="w-container">
    
    
<?php
$titre=NULL;
$contenu=NULL;
$datePublication=NULL;
try 
{
	include('connexion.php'); 
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$dbh->query("SET NAMES 'utf8'");
			$sql = 'SELECT * FROM actualite where publication=1 order by idActualite DESC';
			$resultats = $dbh->query($sql);
			$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
			

		

			foreach ($lignes as $colonne)
			{	
				$titre=$colonne->titre;
				$contenu=$colonne->contenu;
				$datePublication=$colonne->datePublication;
				?>
                		<div class="div-tittle">
			<h4><?php echo $titre; ?></h4> 
			<h6><?php 
			$date = new DateTime($datePublication);
			echo $date->format('d/m/Y');
			 ?></h6>
		</div>
		
		<div id="cadreNews">
			<p><?php echo $contenu; ?></p>
		</div>
        <br><br>
        <hr>
        <?php
			}


?>
    
    

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
 <!-- Script Avatar -->
	<script src=" https://code.jquery.com/jquery-2.1.3.min.js"></script>
   

	<script src="assets/js/jquery.mousewheel.min.js"></script>
   	<script src="croppic.min.js"></script>

    <script>
		var croppicHeaderOptions = {
				//uploadUrl:'img_save_to_file.php',
				cropData:{
					"dummyData":1,
					"dummyData2":"asdas"
				},
				cropUrl:'img_crop_to_file.php',
				customUploadButtonId:'cropContainerHeaderButton',
				modal:false,
				processInline:true,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
				onError:function(errormessage){ console.log('onError:'+errormessage) }
		}	
		var croppic = new Croppic('croppic', croppicHeaderOptions);
		
var croppicContaineroutputOptions = {
				uploadUrl:'img_save_to_file.php',
				cropUrl:'img_crop_to_file.php', 
				outputUrlId:'cropOutput',
				modal:false,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
		}
		var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);
		
		
		
		
	</script>
  
 </body>
 

 </html>

 
<?php 
}	
catch(Exception $e)
{
  //$dbh->rollBack();
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>