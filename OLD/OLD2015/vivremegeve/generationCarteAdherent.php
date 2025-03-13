<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Génération et envoi mail carte adhérent</title>
</head>
<body>
  


<?php

//CONNEXION BASE DE DONNNEES
include('connexion.php');

$dbh->query("SET NAMES utf8");   
$sql= "SELECT * FROM adherents WHERE envoiCarte=0";
$reqAdherents = $dbh->query($sql);

while ($listeAdherents = $reqAdherents->fetch())
{
	$nom=$listeAdherents['nom'];
	$prenom=$listeAdherents['prenom'];
	$urlPhoto=$listeAdherents['urlPhoto'];
	$dateValidite="31/08/2015";
	
	
	
	/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */
    // get the HTML

    ob_start();

?>


<style type="text/css">
<!--
    div.zone { border: none; border-radius: 6mm; background: #FFFFFF; border-collapse: collapse; padding:2mm; font-size: 2.7mm;}
    h1 { padding: 0; margin: 0; color: #03C; font-size: 7mm; font-weight:bold; text-align: center;}
    h2 { padding: 0; margin: 0; color: #090; font-size: 4mm; font-weight:bold; position: relative;   text-align: center;}
-->
</style>
<page format="100x100" orientation="L" backcolor="#CCC" style="font: arial;">
    <div style="position: absolute; width: 300; height: 100; left: 10mm; top: 80mm; font-style: italic; font-weight: normal; text-align: left; font-size: 2.8mm;">
       Ceci est votre carte d'adhérent à l'association Vivre Megève. <br>Vous pouvez l'imprimer afin de la présenter le cas échéant à chaque partenaire de l'association Vivre Megève.
    </div>
    <table style="width: 99%;border: none;" cellspacing="4mm" cellpadding="0">
        <tr>
            <td style="width: 100%">
                <div class="zone" style="height: 53mm;position: relative;font-size: 5mm;">
				
					<h1>CARTE D'ADHERENT </h1>
                    <div style="position: absolute; right: 10mm; top: 9mm; text-align: right; font-size: 6mm; ">
                        <h2>ASSOCIATION VIVRE MEGEVE</h2><br>
                    </div>
                    <div style="position: absolute; left: 28mm; top: 25mm; text-align: left; font-size: 4mm; ">
                        <b><?php echo $nom;?></b><br> <i><?php echo $prenom;?></i><br>
                         
                    </div>
                    
                     <div style="position: absolute; left: 28mm; top: 40mm; text-align: left; font-size: 3mm; ">
                       <b>Date validité :</b> <?php echo $dateValidite;?><br>
                    </div>
                    <div style="position: absolute ; left: 5mm; top: 30%; vertical-align: middle;text-align: center;">
						
						<?php if(file_exists("photos/".$urlPhoto))
						{ ?>
							<img src="photos/<?php echo $urlPhoto;?>" width="71"> 
							<?php
						}
						else
						{
						?>
							<img src="silouette.jpg"> 
							<?php
						} ?>
						
                    </div>
                    
                </div>
            </td>
        </tr>
       
    </table>
</page>
<?php
     $content = ob_get_clean();

    // convert
    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    try
    {	
		
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output("cartesGenerees/".$urlPhoto.".pdf", "F");
	
    }
    catch(HTML2PDF_exception $e) 
	{
        echo $e;
        exit;
    }
	
	
}	
	


$dbh->query("SET NAMES utf8");   
$sql= "SELECT * FROM adherents WHERE envoiCarte=0";
$reqAdherents = $dbh->query($sql);

// On va chercher la définition de la classe
   require('class.phpmailer.php');

while ($listeAdherents = $reqAdherents->fetch())
{
	$urlPhoto=$listeAdherents['urlPhoto'];
	$nom=$listeAdherents['nom'];
	$email=$listeAdherents['email'];
	


 
   // On créé une nouvelle instance de la classe
   $mail = new PHPMailer();
 
   // De qui vient le message, e-mail puis nom
   $mail->From = "contact@vivremegeve.fr";
   $mail->FromName = utf8_decode("Vivre Megève");
 
   // Définition du sujet/objet
   $mail->Subject = utf8_decode("Votre carte adhérent Vivre Megève");
 
   // On définit le corps du message
  $mail->Body = utf8_decode("Bonjour, 
   
Vous trouverez en fichier joint une nouvelle fois votre carte d'adhérent que vous pouvez imprimer, et à laquelle devrait être attachée votre photo d'identité. Si cela n'est pas le cas, nous vous invitons à coller vous même une photo directement sur votre carte.

Bien cordialement,

Le Président de l'association VIVRE MEGEVE
André PERRET");

/*$mail->Body = utf8_decode("Bonjour, 
   
Vous trouverez en fichier joint votre carte d'adhérent que vous pouvez imprimer.

Il importe cependant de vous informer que pour nos deux partenaires actuels (la société des remontées mécaniques de Megève et la société des parkings), il ne sera pas nécessaire de présenter cette carte.  En effet nous leur avons transmis la liste de nos adhérents, qui leur suffit pour vous accorder les remises.

Notre intention pour l'avenir est de travailler à de nouveaux partenariats avec d'autres services à Megève et à cet égard, nous vous invitons à nous faire part de vos idées, besoins et demandes sur la boîte mail : contact@vivremegeve.fr

Bien cordialement,

Le Président de l'association VIVRE MEGEVE
André PERRET");*/
 
 
   // Il reste encore à ajouter au moins un destinataire
   $mail->AddAddress($email, $nom);
 
   // On met notre CV en pièce jointe
   $mail->AddAttachment('cartesGenerees/'.$urlPhoto.'.pdf');
 
   // Pour finir, on envoi l'e-mail
   $mail->send();


  


}	
	


$sql= "UPDATE adherents SET envoiCarte=1";
$reqAdherents = $dbh->query($sql);
	
	


 
?>
	
</body>
</html>

