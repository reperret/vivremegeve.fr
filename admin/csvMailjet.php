<?php

try 
{



include '../connexion.php';
    

$sql="SELECT DISTINCT email from utilisateur where renouvellement=0 and paiement=1  order by email";
if(isset($_GET['prec']) && $_GET['prec']==1)
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


    $sql="select DISTINCT email from utilisateur U where renouvellement=1 and paiement=1 and

    (

    exists
    (
    select * from renouvellement R where U.idUtilisateur=R.idUtilisateur and R.date between '".$anneeSql."-09-01' and '".$anneeSqlPlus1."-08-31' 
    ) 

    or (U.datePaiement  between '".$anneeSql."-09-01' and '".$anneeSqlPlus1."-08-31'  and paiement=1) 

    ) order by email ";
    
}

$resultats = $dbh->query('SET NAMES UTF8');
$resultats = $dbh->query($sql);
$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
$content="email,nom,prénom";
$first=true;
foreach ($lignes as $colonne)
{
    $email=$colonne->email;
    $nom=$colonne->nom;
    $prenom=$colonne->prenom;
    $masque ="/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/";

    if(preg_match($masque, $email))  
    {
        if($first)
        {
            $content=$email;
            $first=false;
        }
        else
        {
            $content=$content."\n".$email;
        }
        
    }     
}

    $handle = fopen("listingEmailsVivreMegeve.txt", "w");
    fwrite($handle, $content);
    fclose($handle);

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename('listingEmailsVivreMegeve.txt'));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('listingEmailsVivreMegeve.txt'));
    readfile('listingEmailsVivreMegeve.txt');
    exit;
    
    
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}


?>
