<?php 
try 
{
include('../connexion.php'); 
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reqUpdate = $dbh->prepare("UPDATE utilisateur set typePaiement=? WHERE idUtilisateur=?");
					$datePublication = new DateTime();
					$reqUpdate->bindParam(1, $_POST['changementTypePaiement']);
					$reqUpdate->bindParam(2, $_POST['idUtilisateur']);
					$reqUpdate->execute();
					

header('Location: index.php'); 
}
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
