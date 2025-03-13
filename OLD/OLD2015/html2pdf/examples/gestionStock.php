<?php

//CONNEXION BASE DE DONNNEES
include('connexion.php');


?>


<!doctype html>
<html>
<head>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
<meta charset="utf-8">
<title>Interface de gestion des stocks</title>
<style>
#carteCadre {
  padding:10px;
  margin:10px;
  border-radius: 12px;
  background-color:#900;
  width:9.2cm;
  height:5.4cm;
}
#photo{
  padding:10px;
  margin:10px;
  float:left;
}

#center{
	margin:auto;
	  width:9.2cm;
}
</style>
</head>

<body>

<h1> Gestion du Stock </h1><br><br>

  <div id="center">
  <?php


$dbh->query("SET NAMES utf8");   
$sql= "SELECT * FROM adherents";
$reqAdherents = $dbh->query($sql);

while ($listeAdherents = $reqAdherents->fetch())
{
?>
	
	<div id="carteCadre">
    <div id="photo">
   <img src="photos/<?php echo $listeAdherents['urlPhoto'];?>"></div>
   <img src="vivremegeve.png">
   <?php
   
	echo "<br>";
	echo $listeAdherents['nom'];
	echo "<br>";
	echo $listeAdherents['prenom'];
	 ?><br><br><br>
     www.vivremegeve.fr
	</div><?php
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	
	?>
	
	<?php
}



		?>
	</div>
</body>
</html>