<?php 	session_start(); 

include('connexion.php');  

$erreur=-1;
$envoi=false;
if (isset($_POST['envoi']) && $_POST['envoi'] == 'ENVOYER') 
{
    
    // Ma clé privée
    $secret = "6LflkJMUAAAAAD1rQQ4WlGC3SL2Fs3f62o-d1GIt";
    // Paramètre renvoyé par le recaptcha
    $response = $_POST['g-recaptcha-response'];
    // On récupère l'IP de l'utilisateur
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $api_url="https://www.google.com/recaptcha/api/siteverify?secret=" 
    . $secret
    . "&response=" . $response
    . "&remoteip=" . $remoteip ;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch); 
    curl_close($ch);


    //echo $output;echo "<br><br>";
    $captcha=json_decode($output, true);

    if ( $captcha['success'] == true )
    {
        // get the posted data
        $name = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email_address = $_POST["email"];
        $telephone = $_POST["telephone"];
        $message = $_POST["message"];

        // write the email content
        $email_content = "Nom : $name<br>";
        $email_content .= "Prenom : $prenom<br>";
        $email_content .= "Adresse email : $email_address<br>";
        $email_content .= "Numero : $telephone<br><br>";
        $email_content .= "Message :<br>$message";

        $envoi=sendMail("contact@vivremegeve.fr", "Nouveau message", $email_content, "Interface admin", "https://www.vivremegeve.fr/admin", "6330280", "nouveau message depuis le site", NULL);

    }
    else 
    {
        $erreur = 'Veuillez valider le captcha ci dessous';
    }
    if($captcha['success'] == false) $erreur = 'Veuillez valider le captcha ci dessous';
}

        


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Association Vivre Megève</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" type="image/x-icon" href="http://www.vivremegeve.fr/vivremegeve3/favicon.ico">
    <script type="text/javascript" src="js/modernizr-2.7.1.js"></script>

    <style type="text/css">
        @media screen and (max-width: 1200px) {
            .div-dobule.x-2 {
                padding-right: 100px;
            }
        }

    </style>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        $('#btn-validate').click(function() {
            var $captcha = $('#recaptcha'),
                response = grecaptcha.getResponse();

            if (response.length === 0) {
                $('.msg-error').text("reCAPTCHA is mandatory");
                if (!$captcha.hasClass("error")) {
                    $captcha.addClass("error");
                }
            } else {
                $('.msg-error').text('');
                $captcha.removeClass("error");
                alert('reCAPTCHA marked');
            }
        })

    </script>
</head>

<body>

    <div class="w-nav navigation" data-collapse="medium" data-animation="default" data-duration="400" data-contain="1">
        <div class="w-container sns-container">
            <a class="w-nav-brand brand" href="index.php">
                <img class="logo" src="images/logo.png" width="200" alt="logo.png">
            </a>

            <?php include 'menu.php'; ?>

            <div class="w-nav-button hamburger">
                <div class="w-icon-nav-menu"></div>
            </div>
        </div>
    </div>


    <div class="w-nav-button hamburger">
        <div class="w-icon-nav-menu"></div>
    </div>
    </div>
    </div>



    <div class="w-section section gray">


        <div class="w-section section features">
            <div class="arrow">
                <div class="arrow-2"></div>
            </div>
            <div class="w-container">
                <div class="second-tittle white-2">
                    <h3>N'hésitez pas à nous contacter</h3>
                </div>
            </div>
        </div>



        <div class="w-section section gray">
            <center>
                <h3>
                    Téléphone :<strong> 06 03 26 38 54</strong> </h3>

                <h3>Tour MAGDELAIN, 28, place de l'église
                    74120 MEGEVE
                </h3>

                <br><br>

                <h3>Vous pouvez aussi nous laisser un message ci dessous</h3>
                <br><br>
            </center>


            <div class="w-container">

                <?php 
$nePasAfficher=0;
if($envoi)
{
    $nePasAfficher=1;
?>
                <div class="div-tittle">
                    <h4>Votre message nous a bien été <span class="color">transmis</span></h4>
                </div>

                <?php 
}
elseif($erreur!=-1)
{
?>
                <div class="div-tittle">
                    <h4><span class="color"><?php echo $erreur ;?></span></h4>
                </div>
                <?php
}
?>
                <div class="w-form">

                    <form action="contact.php" method="post">
                        <center> <span class="msg-error error"></span>
                            <div id="recaptcha" class="g-recaptcha" data-sitekey="6LflkJMUAAAAAFpk1PZYr2XOdnsigAjr9HMybi9m"></div>
                        </center>

                        <input class="w-input text-filed" type="text" placeholder="Nom" name="nom" value="<?php if($nePasAfficher=="0") echo $_POST['nom'];?>">
                        <input class="w-input text-filed no-l" type="text" placeholder="Prénom" name="prenom" value="<?php if($nePasAfficher=="0") echo $_POST['prenom'];?>">
                        <input class="w-input text-filed" type="email" placeholder="Adresse email" name="email" value="<?php if($nePasAfficher=="0")echo $_POST['email'];?>">

                        <input class="w-input text-filed no-l" type="text" placeholder="Téléphone" name="telephone" value="<?php if($nePasAfficher=="0")echo $_POST['telephone'];?>">

                        <textarea class="w-input text-filed _100-p are" name="message" placeholder="Votre message"><?php if($nePasAfficher=="0") echo $_POST['message'];?></textarea>
                        <br><br>


                        <br><br>

                        <input type="hidden" name="envoi" value="ENVOYER">
                        <input class="w-button button sub" type="submit">



                    </form>
                    <br><br><br>
                </div>

            </div>




            <footer class="w-section footer">
                <div class="bottom-footer">
                    <div class="w-container cont-center">
                        <p class="p-footer">Création du site : <a href="http://www.remyperret.com" target="_blank">Rémy PERRET </a></p>
                    </div>
                </div>

                <div class="w-container">

                    <div class="w-row">
                        <div class="w-col w-col-8 col-spc">
                            <div>
                                <h1 class="top-footer">A propos de l'association</h1>
                            </div>
                            <div class="div-spc">
                                <p><em><strong>Association</strong> de type loi "1901" crée à titre non lucratif avec pour objectif de représenter, défendre et informer ses membres en leur qualité d'usager des Services Publics Industriels et Commerciaux (SPIC)<br></em></p>
                            </div>
                        </div>



                        <div class="w-col w-col-4">
                            <div>
                                <h1 class="top-footer">Contact info</h1>
                            </div>
                            <div class="div-spc">
                                <p> <strong>Email:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;contact@vivremegeve.fr<br><strong>Adresse:</strong>&nbsp;&nbsp;&nbsp;&nbsp;Tour MAGDELAIN, 28, place de l'église <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;74120 MEGEVE&nbsp;</p>
                            </div>
                        </div>
                    </div>

                </div>

            </footer>

            <script type="text/javascript" src="js/jquery.min.js"></script>
            <script type="text/javascript" src="js/webflow.a9732dd37.js"></script>
            <!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->


</body>


</html>
