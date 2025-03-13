<?php
require_once('phpexcel/Classes/PHPExcel.php');
include '../connexion.php';
$sql=NULL;

if($_GET['export']==1) $sql="SELECT * from utilisateur where renouvellement=0 and paiement=1 order by nom,prenom";

if($_GET['export']==2) 
{
    $annee=date('Y');
        $mois=date('m');
        $anneeSql=NULL;

        if($mois<9)
        {
            $anneeSql=$annee-2;    
        }
        else
        {
            $anneeSql=$annee-1;
        }
                $anneeSqlPlus1=$anneeSql+1;


    $sql="select * from utilisateur U where renouvellement=1 and paiement=1 and

    (

    exists
    (
    select * from renouvellement R where U.idUtilisateur=R.idUtilisateur and R.date between '".$anneeSql."-09-01' and '".$anneeSqlPlus1."-08-31' 
    ) 

    or (U.datePaiement  between '".$anneeSql."-09-01' and '".$anneeSqlPlus1."-08-31'  and paiement=1) 

    ) order by nom, prenom ";
}

if($_GET['export']==3)     
{
     $annee=date('Y');
    $mois=date('m');
    $anneeSql=NULL;
    
    if($mois<9)
    {
        $anneeSql=$annee-2;    
    }
    else
    {
        $anneeSql=$annee-1;
    }
            $anneeSqlPlus1=$anneeSql+1;
          
	$sql=
"select * from utilisateur U where renouvellement=1 and paiement=1 

and not exists ( select * from renouvellement R where U.idUtilisateur=R.idUtilisateur and date between '".$anneeSql."-09-01' and '".$anneeSqlPlus1."-08-31')

and U.dateAdhesion < '".$anneeSql."-09-01'  

order by nom,prenom";
    
}



function getExports($sql,$dbh)
{
    $enTete=array();
    $export=array();
    $data=array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($sql);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
    $i=0;
    $firstForEnTete=true;
	foreach ($lignes as $colonne)
	{
        $ligneCommande=array();
        
       
        $ligneCommande[]=$colonne->idUtilisateur; 
        $enTete[]="idUtilisateur";
        
        $ligneCommande[]=$colonne->login; 
        $enTete[]="login";
        
        $ligneCommande[]=$colonne->email;
        $enTete[]="email";
        
        $ligneCommande[]=$colonne->civilite;
        $enTete[]="civilite";
        
        $ligneCommande[]=$colonne->typeAdherent;
        $enTete[]="typeAdherent";
        
        $ligneCommande[]=$colonne->dateAdhesion;
        $enTete[]="dateAdhesion";
        
        $ligneCommande[]=$colonne->numAdherent;
        $enTete[]="numAdherent";
        
        $ligneCommande[]=$colonne->numResident;
        $enTete[]="numResident";
        
        $ligneCommande[]=$colonne->nom;
        $enTete[]="nom";
        
        $ligneCommande[]=$colonne->prenom;
        $enTete[]="prenom";
        
        $ligneCommande[]=$colonne->ddn;
        $enTete[]="ddn";
        
        $ligneCommande[]=$colonne->adresse;
        $enTete[]="adresse";
        
        $ligneCommande[]=$colonne->code_postal;
        $enTete[]="code_postal";
        
        $ligneCommande[]=$colonne->ville;
        $enTete[]="ville";
        
        $ligneCommande[]=$colonne->telephone;
        $enTete[]="telephone";
    
       
        if($firstForEnTete){$export[]=$enTete; $firstForEnTete=false; }
        $export[]=$ligneCommande; 
  
    }

    return $export;
    
}



//$export=array(array("en tete 1","en tete 2"),array("ligne 1 col 1 ","ligne 1 col 2"));
$export=getExports($sql,$dbh);


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
