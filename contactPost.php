
<?php


// get the posted data
$name = utf8_encode($_POST["nom"]);
$prenom = utf8_encode($_POST["prenom"]);
$email_address = utf8_encode($_POST["email"]);
$telephone = utf8_encode($_POST["telephone"]);
$message = utf8_encode($_POST["message"]);

		
		
		
		
		
		
// write the email content
$email_content = "Nom : $name\n";
$email_content .= "Prénom : $prenom\n";
$email_content .= "Adresse email : $email_address\n";
$email_content .= "Numéro : $telephone\n";
$email_content .= "Message :\n\n$message";



   // On va chercher la définition de la classe
   require('mail/class.phpmailer.php');
 
   // On créé une nouvelle instance de la classe
   $mail = new PHPMailer();
 
    $mail->ContentType ='text/html';
    $email_content = htmlentities($email_content);

   // De qui vient le message, e-mail puis nom
   $mail->From = $email_address;
   $mail->FromName = "Contact Vivre Megeve";
 
   // Définition du sujet/objet
   $mail->Subject = "Nouveau Message";
 
   // On définit le corps du message
   $mail->Body = stripslashes ($email_content);
 
   // Il reste encore à ajouter au moins un destinataire
   // (ou plus, par plusieurs appel à cette méthode)
   $mail->AddAddress("contact@vivremegeve.fr", "Contact VM");
 
$mail->CharSet = 'UTF-8';
   // Pour finir, on envoi l'e-mail
   $mail->send();



header("Location: contact.php?c=1"); exit;

?>


</html>