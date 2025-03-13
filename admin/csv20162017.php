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

// Fetch Record from Database

$elementsAExporter="U.numAdherent,U.numResident,U.civilite,U.nom,U.prenom,U.ddn,U.adresse,U.code_postal,U.ville,U.telephone,U.email,U.typeAdherent,R.typePaiementRenouvellement,R.date,U.transactionPaiement,R.paiement,U.dateAdhesion
";

$output = "";

$sql_req="
SELECT ".$elementsAExporter." FROM utilisateur U, renouvellement R where U.idUtilisateur=R.idUtilisateur and U.renouvellement=0 and R.paiement=1";
	

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