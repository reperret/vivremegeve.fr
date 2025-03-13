<?php
//**************VERIFICATION DEBUT**********************



$idUtilisateur="";
$email="";
$firstname="";
$lastname="";
$civilite="";
$code_postal="";
$ville="";
$adresse="";
$prenom="";

try 
{
	include('connexion.php'); 
	session_start();	

	

//**************VERIFICATION ADMIN DEBUT**********************
if (!isset($_SESSION['login'])) {
	header ('Location: seconnecter.php');
	exit();
}

	

		// update utilisateur
		$email = $_POST['email'];
		$passmd5 = md5($_POST['pass']);
		$nom = strtoupper($_POST['nom']);
		$prenom=ucfirst(strtolower($_POST['prenom']));
		$telephone=$_POST['telephone'];
		$email=$_POST['email'];
		$jour=$_POST['jour'];
		$mois=$_POST['mois'];
		$annee=$_POST['annee'];
		
		$typeAdherent=$_POST['typeAdherent'];
	
		$civilite=$_POST['civilite'];
		$adresse=$_POST['adresse'];
		$code_postal=$_POST['code_postal'];
		$ville=$_POST['ville'];

		
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->query("SET NAMES 'utf8'");
		
		$ddn=$annee."-".$mois."-".$jour;
		if($_POST['pass']=="MPD_IMPROBABLEHUHUHU")
		{
			
			
			$reqInsert = $dbh->prepare("UPDATE utilisateur SET email=?,nom=?,prenom=?,telephone=?,  civilite=?,adresse=?,code_postal=?,ville=?, typeAdherent=?, ddn=? WHERE idUtilisateur=?");
			$reqInsert->bindParam(1, $email);
			$reqInsert->bindParam(2, $nom);
			$reqInsert->bindParam(3, $prenom);
			$reqInsert->bindParam(4, $telephone);

			$reqInsert->bindParam(5, $civilite );
			$reqInsert->bindParam(6, $adresse );
			$reqInsert->bindParam(7, $code_postal );
			$reqInsert->bindParam(8, $ville );
			$reqInsert->bindParam(9, $typeAdherent );
			$reqInsert->bindParam(10, $ddn );
			$reqInsert->bindParam(11, $_POST['idToEdit'] );	
			
		}
		
		else
		{
			$reqInsert = $dbh->prepare("UPDATE utilisateur SET email=?,nom=?,prenom=?,telephone=?, pass_md5=?, civilite=?,adresse=?,code_postal=?,ville=?, typeAdherent=?, ddn=?  WHERE idUtilisateur=?");
			$reqInsert->bindParam(1, $email);
			$reqInsert->bindParam(2, $nom);
			$reqInsert->bindParam(3, $prenom);
			$reqInsert->bindParam(4, $telephone);
			$reqInsert->bindParam(5, $passmd5);

			$reqInsert->bindParam(6, $civilite );
			$reqInsert->bindParam(7, $adresse );
			$reqInsert->bindParam(8, $code_postal );
			$reqInsert->bindParam(9, $ville );
			$reqInsert->bindParam(10, $typeAdherent );
			$reqInsert->bindParam(11, $ddn );
			$reqInsert->bindParam(12, $_POST['idToEdit']);
		}
		$reqInsert->execute();

	
	
	
	header('Location: compteclient.php'); 

	
}	
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
