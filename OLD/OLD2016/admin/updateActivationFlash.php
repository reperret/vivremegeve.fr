<?php 
try 
{
include('../connexion.php'); 
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reqUpdate = $dbh->prepare("UPDATE parametre set valueParametre=? WHERE idParametre=1");
					$reqUpdate->bindParam(1, $_GET['param']);
					$reqUpdate->execute();
					
header('Location: gestionFlash.php'); 
}
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
