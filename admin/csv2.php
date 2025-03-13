<?php

// Database Connection
include "../connexion.php";

$host=$CSVhost;
$uname=$CSVuname;
$pass=$CSVpass;
$database = $CSVdatabase; 




$connection=mysql_connect($host,$uname,$pass); 

echo mysql_error();

//or die("Database Connection Failed");
$selectdb=mysql_select_db($database) or 
die("Database could not be selected"); 
$result=mysql_select_db($database)
or die("database cannot be selected <br>");

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
          
	
$sql_req="select * from utilisateur U where renouvellement=1 and paiement=1 and

(

exists
(
select * from renouvellement R where U.idUtilisateur=R.idUtilisateur and R.date between '".$anneeSql."-09-01' and '".$anneeSqlPlus1."-08-31' 
) 

or (U.datePaiement  between '".$anneeSql."-09-01' and '".$anneeSqlPlus1."-08-31'  and paiement=1) 

) order by nom, prenom ";

$output = "";


$sql = mysql_query($sql_req);

$columns_total = mysql_num_fields($sql);

// Get The Field Name

for ($i = 0; $i < $columns_total; $i++) {
$heading = mysql_field_name($sql, $i);
$output .= $heading.';';
}
$output .="\n";

// Get Records from the table

while ($row = mysql_fetch_array($sql)) {
for ($i = 0; $i < $columns_total; $i++) {
	
			$chaine=preg_replace("#\n|\t|\r#","",$row["$i"]);
			$output .=trim(utf8_decode(nl2br($chaine))).';';
	
		


}
$output .="\n";
}

// Download the file

$filename = "export".date("d-m-Y").".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo $output;
exit;

?>