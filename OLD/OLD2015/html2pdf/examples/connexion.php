<?php 
try 
{
	$dbh = new PDO('mysql:dbname=vivremegeve;host=mysql1.akeyan.fr', 'vivremegeve', 'vivremegeve');
} 
catch (Exception $e) 
{
  die("Impossible de se connecter: " . $e->getMessage());
}
?>