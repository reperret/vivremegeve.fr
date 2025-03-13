<?php 
//Domaine
$domaine="http://www.vivremegeve.fr//";

//Adresses Email
$emailAlerteSem="resp-caisse.ro@ski.megeve.com";
$emailContact="contact@vivremegeve.fr";
$emailWebmasterAlerte="reperret@hotmaiIl.com";


// SQL
//$CSVhost="localhost";
//$CSVuname="root";
//$CSVpass="";
//$CSVdatabase = "vivremegeve"; 

$CSVhost="mysql1.akeyan.fr";
$CSVuname="vivremegeve";
$CSVpass="vivremegeve";
$CSVdatabase = "vivremegeve"; 



try 
{
	$dbh = new PDO('mysql:dbname='.$CSVdatabase.';host='.$CSVhost, $CSVuname,$CSVpass);
} 
catch (Exception $e) 
{
  die("Impossible de se connecter: " . $e->getMessage());
}


?>