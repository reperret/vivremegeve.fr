<?php
    require('email/class.phpmailer.php');

    $sujet="test envoi remy";
    $email="reperret@gmail.com";
    $email2="reperret@hotmail.com";


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host='in-v3.mailjet.com';
    $mail->SMTPAuth=true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username='4b3bd57ae0831d03ae82bb266a959552' ;
    $mail->Password='efb0e11619c5417a9a3a4a42d7155cb1' ;
    
    $mail->IsHTML(true);
    $mail->CharSet = "utf-8";
    $mail->From = "reperret@hotmail.com";
    $mail->FromName = "PERRET";
    $mail->Subject = $sujet;
    $mail->Body = stripslashes("C'est bon c'est fait. A+");
    $mail->AddAddress($email, $email);
    $mail->AddAddress($email2, $email2);
    $ok=$mail->send();  


?>
    
    
    
    
