<?php 
try 
{
include('../connexion.php'); 
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reqInsert = $dbh->prepare("INSERT INTO actualite (titre,contenu,datePublication) VALUES (?, ?, ?)");
					$datePublication = new DateTime();
					$reqInsert->bindParam(1, $titre);
					$reqInsert->bindParam(2, $contenu);
					$reqInsert->bindParam(3, $datePublication->format('Y-m-d H:i:s'));
					
					$titre=$_POST['titre'];
					$contenu =$_POST['contenu'];

					$reqInsert->execute();



header('Location: gestionActualites.php'); 
}
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
