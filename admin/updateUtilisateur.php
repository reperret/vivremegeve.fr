<?php 
try 
{
include('../connexion.php'); 
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$dbh->query("SET NAMES 'utf8'");
$reqUpdate = $dbh->prepare("UPDATE utilisateur set login=?, email=?,civilite=? ,typeAdherent=?, numResident=?,nom=?,prenom=?, ddn=?,adresse=?,code_postal=?, ville=?,telephone=? WHERE idUtilisateur=?");
					$datePublication = new DateTime();
					$reqUpdate->bindParam(1,$login);
					$reqUpdate->bindParam(2,$email);
					$reqUpdate->bindParam(3,$civilite);
					$reqUpdate->bindParam(4,$typeAdherent);
					$reqUpdate->bindParam(5,$numResident);
					$reqUpdate->bindParam(6,$nom);
					$reqUpdate->bindParam(7,$prenom);
					$reqUpdate->bindParam(8,$ddn);
					$reqUpdate->bindParam(9,$adresse);
					$reqUpdate->bindParam(10,$code_postal);
					$reqUpdate->bindParam(11,$ville);
					$reqUpdate->bindParam(12,$telephone);
					$reqUpdate->bindParam(13,$idUtilisateur);
										
					$login=$_POST['login'];
					$email=$_POST['email'];
					$civilite=$_POST['civilite'];
					$typeAdherent=$_POST['typeAdherent'];
					$numResident=$_POST['numResident'];
					$nom=$_POST['nom'];
					$prenom=$_POST['prenom'];
					$ddn=$_POST['ddn'];
					$adresse=$_POST['adresse'];
					$code_postal=$_POST['code_postal'];
					$ville=$_POST['ville'];
					$telephone=$_POST['telephone'];
					$idUtilisateur=$_POST['idUtilisateur'];


					$reqUpdate->execute();
					

header('Location: index.php'); 
}
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
