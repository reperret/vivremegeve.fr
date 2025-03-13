<?php
$redirect=NULL;
include '../connexion.php';
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

//******VARIABLES RECUPEREES *************
if(isset($_GET['idU']) && isset($_GET['nom']) && isset($_GET['prenom']) && isset($_GET['email']))
{
    $idUtilisateur=$_GET['idU'];
    $nom=$_GET['nom'];
    $prenom=$_GET['prenom'];
    $email=$_GET['email'];
    $ddn=$_GET['ddn'];
    $code_postal=$_GET['code_postal'];
    $ville=$_GET['ville'];
}
elseif(isset($_POST['idU']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']))
{
    $idUtilisateur=$_POST['idU'];
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $email=$_POST['email'];
    $ddn=$_POST['ddn'];
    $code_postal=$_POST['code_postal'];
    $ville=$_POST['ville'];
    
}
//**********VERIFICATION CODE MAIRIE**********************
if(isset($_POST['codeMairie']))
{
    $codeRecupere=trim(strtoupper($_POST['codeMairie']));
}
if(isset($_GET['codeMairieGet']))
{
    $codeRecupere=trim(strtoupper($_GET['codeMairieGet']));
}
$codeMairie=false;
$codeMairie=verifierCodeMairie($codeRecupere,$dbh);



//**********PREPARATION DU MONTANT A PAYER ET DE LA NOTION DE RENOUVELLEMENT********
$montantAnneeEnCoursAfacturer=intval($montantAnneeEnCours)*100;
$renouvellement=0;
if(isset($_POST['r']) && $_POST['r']==1) $renouvellement=1;


//**************************HELLO ASSO PAIEMENT*****************************
//**************************************************************************
//**************************************************************************
//**************************************************************************




//*************DEFINITION DES SECRETS*******************************
$client_id=urlencode("2d88f2b681d94f919159a193feadc7cc");
$client_secret=urlencode("3B4do33plp6ZkHZg6ypd+FC+QX+bOIoX");
$grant_type="client_credentials";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.helloasso.com/oauth2/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=".$grant_type."&client_id=".$client_id."&client_secret=".$client_secret);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) 
{
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

$infos=json_decode($result,true);
$accessToken=$infos['access_token'];



//************PREPARATION DES INFOS JSON PAIEMENT***************************
$idPaiement=NULL;

$jsonClient=array();
$jsonClient['totalAmount']=$montantAnneeEnCoursAfacturer;
$jsonClient['initialAmount']=$montantAnneeEnCoursAfacturer;

$jsonClient['itemName']="Paiement utilisateur ".$idUtilisateur;
$jsonClient['backUrl']=$domaine.'compteclient.php';
$jsonClient['errorUrl']=$domaine.'confirmation.php?type=error';
$jsonClient['returnUrl']=$domaine.'confirmation.php?type=return';
$jsonClient['containsDonation']=false;

$payer=array();
$payer['firstName']=$prenom;
$payer['lastName']=$nom;
$payer['email']=$email;
$payer['dateOfBirth']="1960-01-02";
$payer['address']=$adresse;
$payer['city']=$ville;
$payer['zipCode']=$code_postal;
$jsonClient['payer']=$payer;

$metadata=array();
$metadata['idUtilisateur']=$idUtilisateur;
$metadata['nomUtilisateur']=$nom;
$metadata['prenomUtilisateur']=$prenom;
$metadata['emailUtilisateur']=$email;
$metadata['codeMairie']=$codeRecupere;
$metadata['renouvellement']=$renouvellement;

          
$jsonClient['metadata']=$metadata;


                                                              
//*************CREATION D'UN LIEN DE PAIEMENT*******************************
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.helloasso.com/v5/organizations/vivre-megeve/checkout-intents',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode($jsonClient,true),
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$accessToken,
    'Content-Type: application/json'
  ),
));


$response = curl_exec($curl);

print_r($response);
curl_close($curl);
$lien=json_decode($response,true);
echo $lien['redirectUrl'];

//*************RECUPERATION DU LIEN *******************************
$redirect='Location: '.$lien['redirectUrl'];

//**************************************************************************
//**************************************************************************
//**************************************************************************
//**************************HELLO ASSO PAIEMENT FIN*************************



//*************SI PROBLEME AVEC CODE MAIRIE RETOUR DIRECT AU COMPTE CLIENT*******************************
if($codeMairie==false)    
{
    $redirect='Location: ../compteclient.php?codeMairie=0';
}

//*************REDIRECTION FINALE*******************************
header($redirect);

?>