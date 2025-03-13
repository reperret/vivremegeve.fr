<?php 
try 
{
include('../connexion.php'); 
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reqUpdate = $dbh->prepare("UPDATE renouvellement set typePaiementRenouvellement=? WHERE idRenouvellement=?");
					$datePublication = new DateTime();
					$reqUpdate->bindParam(1, $_POST['changementTypePaiement']);
					$reqUpdate->bindParam(2, $_POST['idRenouvellement']);
					$reqUpdate->execute();
					

header('Location: 20162017.php'); 
}
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
