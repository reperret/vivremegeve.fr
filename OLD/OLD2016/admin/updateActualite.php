<?php 
try 
{
include('../connexion.php'); 
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reqUpdate = $dbh->prepare("UPDATE actualite set titre=?, contenu=?,datePublication=? WHERE idActualite=?");
					$datePublication = new DateTime();
					$reqUpdate->bindParam(1, $titre);
					$reqUpdate->bindParam(2, $contenu);
					$reqUpdate->bindParam(3, $datePublication->format('Y-m-d H:i:s'));
					$reqUpdate->bindParam(4, $_POST['idActualite']);
					
					$titre=$_POST['titre'];
					$contenu =$_POST['contenu'];

					$reqUpdate->execute();
					

header('Location: gestionActualites.php'); 
}
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
