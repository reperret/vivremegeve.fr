<?php 
try 
{
include('../connexion.php');  
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$req = $dbh->prepare('DELETE From actualite WHERE idActualite=?');
$req->execute(array($_GET['idToDelete']));

header('Location: gestionActualites.php'); 
}
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
