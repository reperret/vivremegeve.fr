<?php 
try 
{
include('../connexion.php'); 
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $reqDelete = $dbh->prepare("DELETE from document where idDocument=?");
    $reqDelete->bindParam(1, $idDocument);
    $idDocument=$_GET['idDocument'];
    $reqDelete->execute();

header('Location: modifierActualite.php?idToEdit='.$_GET['idDocument']); 
}
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
