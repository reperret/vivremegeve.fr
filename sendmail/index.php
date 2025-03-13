<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'api/src/Exception.php';
require 'api/src/PHPMailer.php';
require 'api/src/SMTP.php';

$envoiMail=NULL;
   
if(
    (
        isset($_POST['emailExpediteur']) && $_POST['emailExpediteur']!='' && 
        isset($_POST['nomExpediteur']) && $_POST['nomExpediteur']!=''     && 
        isset($_POST['emailDestinataire']) && $_POST['emailDestinataire']!=''     && 
        isset($_POST['numeroTemplate']) && $_POST['numeroTemplate']!=''     &&
        isset($_POST['tag_titre']) && $_POST['tag_titre']!=''     &&
        isset($_POST['tag_contenu']) && $_POST['tag_contenu']!=''     &&
        isset($_POST['tag_lienbouton']) && $_POST['tag_lienbouton']!=''     &&
        isset($_POST['tag_libellebouton']) && $_POST['tag_libellebouton']!=''     &&
        isset($_POST['sujet']) && $_POST['sujet']!='' 
    )
    ||
    (
        isset($_GET['emailExpediteur']) && $_GET['emailExpediteur']!='' && 
        isset($_GET['nomExpediteur']) && $_GET['nomExpediteur']!=''     && 
        isset($_GET['emailDestinataire']) && $_GET['emailDestinataire']!=''     && 
        isset($_GET['numeroTemplate']) && $_GET['numeroTemplate']!=''     &&
        isset($_GET['tag_titre']) && $_GET['tag_titre']!=''     &&
        isset($_GET['tag_contenu']) && $_GET['tag_contenu']!=''     &&
        isset($_GET['tag_lienbouton']) && $_GET['tag_lienbouton']!=''     &&
        isset($_GET['tag_libellebouton']) && $_GET['tag_libellebouton']!=''     &&
        isset($_GET['sujet']) && $_GET['sujet']!=''  
    )
    
  )
{

if(isset($_POST['emailExpediteur']))
{
    $emailExpediteur=$_POST['emailExpediteur'];
    $nomExpediteur=$_POST['nomExpediteur'];
    $emailDestinataire=$_POST['emailDestinataire'];
    $numeroTemplate=$_POST['numeroTemplate'];
    $sujet=$_POST['sujet'];
    $tag_titre=$_POST['tag_titre'];
    $tag_contenu=$_POST['tag_contenu'];
    $tag_lienbouton=$_POST['tag_lienbouton'];
    $tag_libellebouton=$_POST['tag_libellebouton'];
    $tag_lienbouton2=$_POST['tag_lienbouton2'];
    $tag_libellebouton2=$_POST['tag_libellebouton2'];
    $tag_lienbouton3=$_POST['tag_lienbouton3'];
    $tag_libellebouton3=$_POST['tag_libellebouton3'];
}

if(isset($_GET['emailExpediteur']))
{
    $emailExpediteur=$_GET['emailExpediteur'];
    $nomExpediteur=$_GET['nomExpediteur'];
    $emailDestinataire=$_GET['emailDestinataire'];
    $numeroTemplate=$_GET['numeroTemplate'];
    $sujet=$_GET['sujet'];
    $tag_titre=$_GET['tag_titre'];
    $tag_contenu=$_GET['tag_contenu'];
    $tag_lienbouton=$_GET['tag_lienbouton'];
    $tag_libellebouton=$_GET['tag_libellebouton'];
    $tag_lienbouton2=$_GET['tag_lienbouton2'];
    $tag_libellebouton2=$_GET['tag_libellebouton2'];
    $tag_lienbouton3=$_GET['tag_lienbouton3'];
    $tag_libellebouton3=$_GET['tag_libellebouton3'];
}



$template = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/sendmail/api/template'.$numeroTemplate.'.html'); 

$template = str_replace('[TAG_TITRE]', $tag_titre, $template); 
$template = str_replace('[TAG_CONTENU]', $tag_contenu, $template); 
$template = str_replace('[TAG_LIENBOUTON]', $tag_lienbouton, $template); 
$template = str_replace('[TAG_LIBELLEBOUTON]', $tag_libellebouton, $template); 

if($tag_lienbouton2!="" && $tag_libellebouton2!="")
{
    $template = str_replace('[TAG_LIENBOUTON2]', $tag_lienbouton2, $template); 
    $template = str_replace('[TAG_LIBELLEBOUTON2]', $tag_libellebouton2, $template);
}
    
if($tag_lienbouton3!="" && $tag_libellebouton3!="")
{
    $template = str_replace('[TAG_LIENBOUTON3]', $tag_lienbouton3, $template); 
    $template = str_replace('[TAG_LIBELLEBOUTON3]', $tag_libellebouton3, $template);
}


    
$mail = new PHPMailer;
$mail->isSMTP(); 
$mail->Host ='in-v3.mailjet.com';   
$mail->Port = "587";
$mail->SMTPSecure = 'tls'; 
$mail->SMTPAuth = true;
$mail->Username = "5836955ec62772c92e606d3abaec4b6b";
$mail->Password = "2af83dca15d562c1c6904a26be6ecc82";
$mail->setFrom($emailExpediteur, $nomExpediteur);
$mail->addAddress($emailDestinataire);

$mail->IsHTML(true);
$mail->CharSet = "utf-8";
$mail->Subject = $sujet;
$mail->Body = stripslashes($template);
$mail->AltBody = 'VERSION TEXTE BRUTE';

//$mail->addAttachment('api/brochure.pdf'); //Attachment, can be skipped
$envoiMail=$mail->send();


}
else
{
    $envoiMail="BAD_ARGUMENTS";
}

echo $envoiMail;


?>
