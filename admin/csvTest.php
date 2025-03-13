<?php
require_once('phpexcel/Classes/PHPExcel.php');
include '../connexion.php';

function getExports($dbh)
{
    $enTete=array();
    $export=array();
    $data=array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query("SELECT * from utilisateur");
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
    $i=0;
    $firstForEnTete=true;
	foreach ($lignes as $colonne)
	{
        $ligneCommande=array();
        
        
       
        $ligneCommande[]=$colonne->nom; 
        $enTete[]="Nom";
        
        $ligneCommande[]=$colonne->prenom;
        $enTete[]="Prenom";
    
       
        if($firstForEnTete){$export[]=$enTete; $firstForEnTete=false; }
        $export[]=$ligneCommande; 
  
    }

    return $export;
    
}



//$export=array(array("en tete 1","en tete 2"),array("ligne 1 col 1 ","ligne 1 col 2"));
$export=getExports($dbh);


$doc = new PHPExcel();

//*****GPSPORTS******
$objWorkSheet = $doc->createSheet(0);
$doc->setActiveSheetIndex(0);
$doc->getActiveSheet()->fromArray($export);
$objWorkSheet->setTitle("Adherents");


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . "export.xls" . '"');
header('Cache-Control: max-age=0'); 

$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
$objWriter->save('php://output');
?>
