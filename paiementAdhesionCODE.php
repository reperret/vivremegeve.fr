<?php
require_once('lib/init.php');
//\Payplug\Payplug::setSecretKey('sk_live_62879aa82b1cb2fa9ca0ecf54ad335ab');
\Payplug\Payplug::setSecretKey('sk_test_d634650d8237a0ef6929a769754f775b');
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
}
elseif(isset($_POST['idU']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']))
{
    $idUtilisateur=$_POST['idU'];
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $email=$_POST['email'];
    
}
//**********VERIFICATION CODE MAIRIE**********************
if(isset($_POST['codeMairie']))
{
    $codeRecupere=trim(strtoupper($_POST['codeMairie']));
}
if(isset($_GET['codeMairieGet']))
{
    $codeRecupere=trim(strtoupper($_POST['codeMairieGet']));
}
$codeMairie=false;
$codeMairie=verifierCodeMairie($codeRecupere,$dbh);




$montantAnneeEnCoursAfacturer=intval($montantAnneeEnCours)*100;
$renouvellement=0;
if(isset($_POST['r']) && $_POST['r']==1) $renouvellement=1;

$payment = \Payplug\Payment::create(array(
  'amount'           => $montantAnneeEnCoursAfacturer,
  'currency'         => 'EUR',
  'billing'  => array(
    'title'        => 'mr',
    'first_name'   => $prenom,
    'last_name'    => $nom,
    'email'        => $email,
    'address1'     => 'Tour Magelan',
    'postcode'     => '74120',
    'city'         => 'Megève',
    'country'      => 'FR',
    'language'     => 'fr'
  ),
  'shipping'  => array(
    'title'         => 'mr',
    'first_name'    => $prenom,
    'last_name'     => $nom,
    'email'         => $email,
    'address1'     => 'Tour Magelan',
    'postcode'     => '74120',
    'city'         => 'Megève',
    'country'      => 'FR',
    'language'     => 'fr',
    'delivery_type' => 'BILLING'
  ),
  'hosted_payment'   => array(
    'return_url'     => $domaine.'confirmation.php',
    'cancel_url'     => $domaine.'annulation.php'
  ),
  'notification_url' => $domaine.'payplug/ipnCODE.php?r='.$renouvellement,
  'metadata'         => array(
      'idUtilisateur'        => $idUtilisateur,
      'nomUtilisateur'       => $nom,
      'prenomUtilisateur'    => $prenom,
      'emailUtilisateur'     => $email,
      'codeMairie'           => $codeRecupere
  )
));

$payment_url = $payment->hosted_payment->payment_url;
$payment_id = $payment->id;

$redirect='Location:' . $payment_url;
if($codeMairie==false)    
{
    $redirect='Location: ../compteclientCODE.php?codeMairie=0';
}

header($redirect);

?>