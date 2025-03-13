<?php 
try 
{
include('../connexion.php'); 
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$dbh->query("SET NAMES 'utf8'");
$reqUpdate = $dbh->prepare("UPDATE actualite set titre=?, contenu=?,datePublication=? WHERE idActualite=?");
					$datePublication = new DateTime();
					$reqUpdate->bindParam(1, $titre);
					$reqUpdate->bindParam(2, $contenu);
					$reqUpdate->bindParam(3, $datePublication->format('Y-m-d H:i:s'));
					$reqUpdate->bindParam(4, $_POST['idActualite']);
					
					$titre=$_POST['titre'];
					$contenu =$_POST['contenu'];

					$reqUpdate->execute();
    

$idActualite=$_POST['idActualite'];
if($_FILES['pj1']['name'] != "")
{
    $pj1=upload('pj1');
    $reqInsert = $dbh->prepare("INSERT INTO document (titreDocument,nomDocument, idActualite) VALUES (?,?,?)");
    $datePublication = new DateTime();
    $reqInsert->bindParam(1, $titre);
    $reqInsert->bindParam(2, $pj1);
    $reqInsert->bindParam(3, $idActualite);
    $titre=$_POST['titre1'];
    $reqInsert->execute();
}

if($_FILES['pj2']['name'] != "")
{
    $pj1=upload('pj2');
    $reqInsert = $dbh->prepare("INSERT INTO document (titreDocument,nomDocument, idActualite) VALUES (?,?,?)");
    $datePublication = new DateTime();
    $reqInsert->bindParam(1, $titre);
    $reqInsert->bindParam(2, $pj1);
    $reqInsert->bindParam(3, $idActualite);
    $titre=$_POST['titre2'];
    $reqInsert->execute();
}

if($_FILES['pj3']['name'] != "")
{
    $pj1=upload('pj3');
    $reqInsert = $dbh->prepare("INSERT INTO document (titreDocument,nomDocument, idActualite) VALUES (?,?,?)");
    $datePublication = new DateTime();
    $reqInsert->bindParam(1, $titre);
    $reqInsert->bindParam(2, $pj1);
    $reqInsert->bindParam(3, $idActualite);
    $titre=$_POST['titre3'];
    $reqInsert->execute();
}
    
if($_FILES['pj4']['name'] != "")
{
    $pj1=upload('pj4');
    $reqInsert = $dbh->prepare("INSERT INTO document (titreDocument,nomDocument, idActualite) VALUES (?,?,?)");
    $datePublication = new DateTime();
    $reqInsert->bindParam(1, $titre);
    $reqInsert->bindParam(2, $pj1);
    $reqInsert->bindParam(3, $idActualite);
    $titre=$_POST['titre4'];
    $reqInsert->execute();
}
    
if($_FILES['pj5']['name'] != "")
{
    $pj1=upload('pj5');
    $reqInsert = $dbh->prepare("INSERT INTO document (titreDocument,nomDocument, idActualite) VALUES (?,?,?)");
    $datePublication = new DateTime();
    $reqInsert->bindParam(1, $titre);
    $reqInsert->bindParam(2, $pj1);
    $reqInsert->bindParam(3, $idActualite);
    $titre=$_POST['titre5'];
    $reqInsert->execute();
}
    
    
    
header('Location: gestionActualites.php'); 
}
catch(Exception $e)
{
  echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération." ;
  echo $e->getMessage();
}
?>
