<?php 
try 
{
include('../connexion.php'); 
$dbh->query("SET NAMES 'utf8'");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reqInsert = $dbh->prepare("INSERT INTO flash (infoFlash,dateFlash) VALUES (?, ?)");
					$datePublication = new DateTime();
					$reqInsert->bindParam(1, $contenu);
					$reqInsert->bindParam(2, $datePublication->format('Y-m-d H:i:s'));
					$contenu =$_POST['contenu'];
					$reqInsert->execute();



header('Location: gestionFlash.php'); 
}
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
