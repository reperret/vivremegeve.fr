<?php

function genererIdentifiantClient($idSql)
{
	$prefixe=substr(time(), -5);
	$suffixe=NULL;
	for($i=0;$i<5-strlen($idSql);$i++)
	{
		$suffixe=$suffixe."0";
	}
	return $prefixe.$suffixe.$idSql;
		
}


function checkDoublon($numResident,$nom,$prenom,$ddn, $dbh)
{
	$sql = 'SELECT count(*) AS nbre FROM utilisateur WHERE (nom="'.$nom.'" AND prenom="'.$prenom.'" AND ddn="'.$ddn.'") OR numResident="'.$numResident.'"';
	$resultats = $dbh->query($sql);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	
	$dbh->query("SET NAMES 'utf8'");
	$nbLignes=0;
	foreach ($lignes as $colonne)
	{
		$nbLignes=$colonne->nbre;
	}
	
	return $nbLignes;
}

function verifierLoginExistant($login,$dbh)
{
    $sql= "SELECT count(*) AS nbre FROM utilisateur WHERE login='".$login."'";
	$resultats = $dbh->query($sql);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	
	$dbh->query("SET NAMES 'utf8'");
	$nbLignes=0;
	foreach ($lignes as $colonne)
	{
		$nbLignes=$colonne->nbre;
	}
	return $nbLignes;
}


try 
{
	


	include('connexion.php');
    include('generationCarteAdherentFonction.php');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription') 
{
    
    

    
    	// Ma clé privée
	$secret = "6LdC8hcTAAAAAP5ymwIVmOKyiznK0oRksUa7M7G0";
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
   

	
	if ( $captcha['success'] == true &&
        (isset($_POST['login']) && !empty($_POST['login']))  && 
		(isset($_POST['email']) && !empty($_POST['email']))  && 
		(isset($_POST['pass']) && !empty($_POST['pass']))  &&
		(isset($_POST['nom']) && !empty($_POST['nom']))  && 
		(isset($_POST['prenom']) && !empty($_POST['prenom']))  && 
		(isset($_POST['code_postal']) && !empty($_POST['code_postal']))  && 
		(isset($_POST['adresse']) && !empty($_POST['adresse']))  && 
		(isset($_POST['ville']) && !empty($_POST['ville']))  && 
		(isset($_POST['civilite']) && !empty($_POST['civilite']))  &&   
		(isset($_POST['numResident']) && !empty($_POST['numResident']))  &&  
		(isset($_POST['jour']) && !empty($_POST['jour']))  && 
		(isset($_POST['mois']) && !empty($_POST['mois']))  &&
		(isset($_POST['annee']) && !empty($_POST['annee']))  && 
		(isset($_POST['choixPaiement']) && !empty($_POST['choixPaiement']))  && 
		(isset($_POST['typeAdherent']) && !empty($_POST['typeAdherent']))  
) 
	{
	
		if ($_POST['pass'] != $_POST['pass_confirm']) 
		{
			$erreur = 'Les 2 mots de passe sont différents.';
		}
		else 
		{
           
       
           
            //*******VERIFICATION CODE MAIRIE**************
            $codeRecupere=trim(strtoupper($_POST['codeMairie']));
            $codeMairie=false;
            $codeMairie=verifierCodeMairie($codeRecupere,$dbh);
            
            
            //*******CHECK DOUBLON**************
            $checkDoublon=0;
            $checkDoublon=checkDoublon("01-".$_POST['numResident']."-".$_POST['numResident2'],$_POST['nom'],$_POST['prenom'],$_POST['annee']."-".$_POST['mois']."-".$_POST['jour'],$dbh);

     
            //*******VERIFIER SI LOGIN DEJA EXISTANT*************
            $loginExistant=0;
            $loginExistant=verifierLoginExistant($_POST['login'],$dbh);
        
			
				if($loginExistant==0  && $checkDoublon==0 && $codeMairie) 
				{
                 
					$idUtilisateur=NULL;
					
					
					//$dbh->beginTransaction();
					$reqInsert = $dbh->prepare("INSERT INTO utilisateur (email,pass_md5,nom,prenom,telephone,code_postal,adresse,ville,code_postal2,adresse2,ville2, civilite, numResident, urlPhoto, ddn, typeAdherent, typePaiement, dateAdhesion, login, logNavigateur, renouvellement, montantAdhesion ,codeMairie) VALUES (?, ?, ?, ?, ?, ?, ?, ? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)");
					
					
					$reqInsert->bindParam(1, $email);
					$reqInsert->bindParam(2, $passmd5);
					$reqInsert->bindParam(3, $nom);
					$reqInsert->bindParam(4, $prenom);
					$reqInsert->bindParam(5, $telephone);
                    
					$reqInsert->bindParam(6, $code_postal);
					$reqInsert->bindParam(7, $adresse);
					$reqInsert->bindParam(8, $ville);
                    
                    $reqInsert->bindParam(9, $code_postal2);
					$reqInsert->bindParam(10, $adresse2);
					$reqInsert->bindParam(11, $ville2);
                    
                    
					$reqInsert->bindParam(12, $civilite);
					$reqInsert->bindParam(13, $numResident);
					$reqInsert->bindParam(14, $urlAvatar);
					$reqInsert->bindParam(15, $ddn);
					$reqInsert->bindParam(16, $typeAdherent);
					$reqInsert->bindParam(17, $choixPaiement);
					$reqInsert->bindParam(18, $dateAdhesion);
					$reqInsert->bindParam(19, $login);
					$reqInsert->bindParam(20, $logNavigateur);
					$reqInsert->bindParam(21, $renouvellement);
					$reqInsert->bindParam(22, $montantAnneeEnCours);
                    $reqInsert->bindParam(23, $codeRecupere);
                    
					
					
					
					
					// insertion d'une ligne
					$annee=$_POST['annee'];
					$mois=$_POST['mois'];
					$jour=$_POST['jour'];
					$ddn=$annee."-".$mois."-".$jour;
					$login = trim($_POST['login']);
					$email = trim($_POST['email']);
					$passmd5 = md5($_POST['pass']);
					$nom = strtoupper($_POST['nom']);
					$prenom=ucfirst(strtolower($_POST['prenom']));
					$telephone=$_POST['telephone'];
                    
					$code_postal=$_POST['code_postal'];
					$adresse=$_POST['adresse'];
					$ville=$_POST['ville'];
                    
                    $code_postal2=$_POST['code_postal2'];
					$adresse2=$_POST['adresse2'];
					$ville2=$_POST['ville2'];
                    
                    
					$civilite=$_POST['civilite'];
					$numResident="01-".$_POST['numResident']."-".$_POST['numResident2'];
					$urlAvatar=$_POST['cropOutput'];
					$choixPaiement=$_POST['choixPaiement'];
					$typeAdherent=$_POST['typeAdherent'];
					$dateAdhesion=date("Y-m-d H:i:s");
					$logNavigateur=$_SERVER['HTTP_USER_AGENT'];
					$renouvellement="0";
					$reqInsert->execute();
					$idUtilisateur=$dbh->lastInsertId();  
					
                 
					$numAdherent=genererIdentifiantClient($idUtilisateur);

					//**** Génération de la carte PDF  ****
					
					$urlCarte=generateCarteUtilisateur($idUtilisateur,'', $numAdherent, $dbh);
				
					//**** FIN Génération de la carte PDF + numéro adhérentr ****
	
	
					//***********MISE A JOUR NUM ADHERENT ET URL CARTE ********************
					$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$reqUpdate = $dbh->prepare("UPDATE utilisateur SET numAdherent=?, urlCarte=? WHERE idUtilisateur=?");
					$reqUpdate->bindParam(1,$numAdherent); 
					$reqUpdate->bindParam(2,$urlCarte);
					$reqUpdate->bindParam(3,$idUtilisateur);
					$reqUpdate->execute();
					//**********FIN MISE A JOUR NUM ADHERENT ET URL CARTE ********************
			

                    
                    
					
	
					session_start();
					$_SESSION['login'] = $_POST['login'];
					
					
					$redirect=NULL;
					if($choixPaiement=="cb")
					{
						$redirect='Location: payplug/paiementAdhesion.php?idU='.$idUtilisateur.'&nom='.$nom.'&prenom='.$prenom.'&email='.$email.'&codeMairieGet='.$codeRecupere;
					}
					else
					{
						
			//******************** ENVOI MAIL ************************
			require('mail/class.phpmailer.php');
			$mail = new PHPMailer();
			$mail->CharSet = 'UTF-8';
			$mail->From = "contact@vivremegeve.fr";
			$mail->FromName = "Vivre Megève";
			$mail->Subject = "confirmation inscription";						 
			$body = "<center>
		<img src='".$domaine."images/logoMail.jpg'></center><br><br>
		Bonjour ".$prenom." ".$nom."<br>
			
		Nous vous remercions pour votre inscription. Afin de finaliser celle-ci, nous vous prions d'envoyer un chèque de ".$montantAnneeEnCours."€ à l'ordre de Association Vivre Megève à l'adresse suivante :<br><br>
		
		
		Association Vivre Megève<br>
		Tour MAGDELAIN<br>
		28, place de l'église<br>
		74120 MEGEVE <br>
		<br><br>
		
		Veuillez de plus préciser dans cet envoi votre numéro d'adhérent : ".$numAdherent."<br><br>
		
		En attendant, vous pouvez accéder à votre <a href=\"".$domaine."compteclient.php\">Espace client</a>.<br><br>
		
		La présidente, Annick SOCQUET CLERC.";
			
			$mail->MsgHTML($body);			 
			$mail->AddAddress($email, $nom." ".$prenom);
			$mail->send();
			//******************** FIN GENERATION EMAIL CONFIRMATION CLIENT************************
						$redirect='Location: confirmationCheque.php?n='.$numAdherent;
					}
					
					
					header($redirect);
					exit();
				}
				else 
				{
                    if ($loginExistant==1) 
                    {
                        $erreur .= 'Un membre possède déjà ce pseudonyme (auquel cas veuillez en choisir un autre), ou vous avez déjà un compte existant.<br>';
                    }
                    if ($checkDoublon==1) 
                    {
                        $erreur .= 'Ce numéro de résident existe déjà<br>';
                    }
                    if($codeMairie==false)
                    {
                        $erreur .= 'Le code de la mairie que vous avez indiqué est invalide ou déjà utilisé. Veuillez le resaisir ou vérifier auprès de la mairie.<br>';
                    }
					
				}	

		
			
		}
	}
	else 
	{
		$erreur = 'Au moins un des champs est vide.';
	}
    if($captcha['success'] == false) $erreur = 'Veuillez valider le captcha en bas de page';
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
    <link rel="shortcut icon" type="image/x-icon" href="https://www.vivremegeve.fr/vivremegeve3/favicon.ico">
    <script type="text/javascript" src="js/modernizr-2.7.1.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">

    <!-- AVATAR-->
    <link href="assets/css/croppic.css" rel="stylesheet">

    <style type="text/css">
        msg-error {
            color: #c65848;
        }

        .red {
            color: red;
            font-weight: bold;
            font-weight: 1.1em;
        }

        .g-recaptcha.error {
            border: solid 2px #c64848;
            padding: .2em;
            width: 19em;
        }

        @media screen and (max-width: 1200px) {
            .div-dobule.x-2 {
                padding-right: 100px;
            }
        }

        .button-success {
            background: rgb(201, 41, 42);
            /* this is a maroon */
            font-size: 200%;
            color: #FFF;
            font-weight: 900;
        }

        .hp {
            display: none;
        }


        .erreurRouge {

            text-align: center;
            margin: auto;
            background-color: firebrick;
            color: #FFF;
            font-weight: bold;
            font-size: 1.5em;
            padding: 10px;
            max-width: 80%;
        }

    </style>


    <script language="Javascript">
        function validerTaille(monchamps) {
            var taille = 20;
            if (monchamps.value.length != taille) {
                // Envoi d'une alerte
                alert('Ce champ doit contenir exactement 20 chiffres');
                monchamps.value = "";
                return false
            }

        }



        function verif_nombre20(champ) {
            var chiffres = new RegExp("[0-9]");
            var verif;
            var points = 0;

            for (x = 0; x < champ.value.length; x++) {
                verif = chiffres.test(champ.value.charAt(x));
                if (champ.value.charAt(x) == ".") {
                    points++;
                }
                if (points > 1) {
                    verif = false;
                    points = 1;
                }
                if (verif == false) {
                    champ.value = champ.value.substr(0, x) + champ.value.substr(x + 1, champ.value.length - x + 1);
                    x--;
                }
                if (champ.value.length > 20) {
                    champ.value = champ.value.substr(0, 20);
                }

            }
        }


        function verifLogin(champ) {
            var chiffres = new RegExp("[a-zA-Z0-9]");
            var verif;
            var points = 0;

            for (x = 0; x < champ.value.length; x++) {
                verif = chiffres.test(champ.value.charAt(x));
                if (champ.value.charAt(x) == ".") {
                    points++;
                }
                if (points > 1) {
                    verif = false;
                    points = 1;
                }
                if (verif == false) {
                    champ.value = champ.value.substr(0, x) + champ.value.substr(x + 1, champ.value.length - x + 1);
                    x--;
                }
                if (champ.value.length > 35) {
                    champ.value = champ.value.substr(0, 35);
                }

            }
        }

    </script>


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



    <div class="w-section section gray">


        <div class="w-section section features">
            <div class="arrow">
                <div class="arrow-2"></div>
            </div>
            <div class="w-container">
                <div class="second-tittle white-2">

                    <h3>Veuillez remplir ce formulaire s'il vous plait</h3>
                </div>
            </div>
        </div>

        <div class="w-section section s-2">
            <div class="w-container">


                <?php
if (isset($erreur)) 
{
	echo '<br /><br /><div class="erreurRouge">',$erreur."</div><br><br><br><br>";
	?>

                <?php	
}
?>

                <div class="div-tittle">
                    <h1>Inscriptions 2024-2025</h1>
                    <h2><strong> ATTENTION </strong>: si vous souhaitez renouveler votre adhésion, et que vous possédez donc DEJA un compte, veuillez vous connecter à votre <a href="compteclient.php">espace adhérent</a></h2>


                </div>
                <center><u>Les informations ci dessous ne seront pas diffusées</u><br> Une inscription sur cette page correspondant à une et une seule personne physique. Vous pouvez créer différents comptes avec différents pseudonymes tout en utilisant une même adresse email.<br><br>
                    <strong><u>Le pseudonyme que vous devez choisir est libre, c'est vous qui l'inventez. Il ne doit pas comporter d'espace ni d'accent. (exemple : "toto74skieur")</u></strong>
                </center><br><br>

                <div class="center">
                    * : champ obligatoire<br><br>


                    <form action="inscription.php" method="post" class="pure-form pure-form-aligned">
                        <fieldset>
                            <div class="pure-control-group">
                                <label for="civilite">Civilite *</label>

                                <?php
                                $checkedHomme=" checked";
                                $checkedFemme=" "; 
                                if(isset($_POST['civilite']) && $_POST['civilite']=="Monsieur")
                                {
                                    $checkedHomme=" checked";
                                    $checkedFemme=" "; 
                                }
                                if(isset($_POST['civilite']) && $_POST['civilite']=="Madame")
                                {
                                    $checkedHomme=" ";
                                    $checkedFemme=" checked"; 
                                }
                                
                                ?>
                                <input id="option-two" type="radio" name="civilite" value="Monsieur" <?php echo $checkedHomme;?>>
                                Homme


                                <input id="option-three" type="radio" name="civilite" value="Madame" <?php echo $checkedFemme;?>>
                                Femme

                            </div>


                            <div class="pure-control-group">
                                <label for="login">Pseudonyme* (inventez ce que vous voulez)</label>
                                <input type="text" placeholder="Pseudonyme" name="login" value="<?php if(isset($_POST['loginInscription'])){echo htmlentities(utf8_decode(trim($_POST['loginInscription']))); }elseif (isset($_POST['login'])) {echo htmlentities(utf8_decode(trim($_POST['login']))); }?>" onkeyup="verifLogin(this);" required>
                            </div>




                            <div class="pure-control-group">
                                <label for="nom">Nom *</label>
                                <input type="text" placeholder="Nom" name="nom" value="<?php if (isset($_POST['nom'])) echo htmlentities(utf8_decode(trim($_POST['nom']))); ?>" required>
                            </div>

                            <div class="pure-control-group">
                                <label for="prenom">Prenom *</label>
                                <input type="text" placeholder="Prenom" name="prenom" value="<?php if (isset($_POST['prenom'])) echo trim($_POST['prenom']); ?>" required>
                            </div>



                            <div class="pure-control-group">
                                <label for="ddn">Date de naissance *</label>
                                <select name="jour" style="width:60px">
                                    <option value=""></option>

                                    <?php
			 for($i=1;$i<=31;$i++)
			 { 
				 if(strlen($i)==1)
				 { ?>
                                    <option value="0<?php echo $i; ?>" <?php if($_POST['jour']=="0".$i) echo "selected"; ?>>0<?php echo $i; ?></option> <?php
				 }
				 else
				 {
					 ?>
                                    <option value="<?php echo $i; ?>" <?php if($_POST['jour']==$i) echo "selected"; ?>><?php echo $i; ?></option> <?php
				 }				 
			 }
			 ?>

                                </select>
                                <select name="mois" style="width:80px">
                                    <option value=""></option>
                                    <option value="01" <?php if($_POST['mois']=="01") echo "selected"; ?>>Janvier</option>
                                    <option value="02" <?php if($_POST['mois']=="02") echo "selected"; ?>>Février</option>
                                    <option value="03" <?php if($_POST['mois']=="03") echo "selected"; ?>>Mars</option>
                                    <option value="04" <?php if($_POST['mois']=="04") echo "selected"; ?>>Avril</option>
                                    <option value="05" <?php if($_POST['mois']=="05") echo "selected"; ?>>Mai</option>
                                    <option value="06" <?php if($_POST['mois']=="06") echo "selected"; ?>>Juin</option>
                                    <option value="07" <?php if($_POST['mois']=="07") echo "selected"; ?>>Juillet</option>
                                    <option value="08" <?php if($_POST['mois']=="08") echo "selected"; ?>>Août</option>
                                    <option value="09" <?php if($_POST['mois']=="09") echo "selected"; ?>>Septembre</option>
                                    <option value="10" <?php if($_POST['mois']=="10") echo "selected"; ?>>Octobre</option>
                                    <option value="11" <?php if($_POST['mois']=="11") echo "selected"; ?>>Novembre</option>
                                    <option value="12" <?php if($_POST['mois']=="12") echo "selected"; ?>>Décembre</option>
                                </select>
                                <select name="annee" style="width:80px">
                                    <option value=""></option>
                                    <?php
			 for($i=1900;$i<=date("Y");$i++)
			 { 
			 ?>

                                    <option value="<?php echo $i; ?>" <?php if($_POST['annee']==$i) echo "selected"; ?>><?php echo $i; ?></option>

                                    <?php
				 
			 }
			 ?>
                                </select>
                            </div>




                            <div class="pure-control-group">
                                <label for="login">Email *</label>
                                <input type="email" placeholder="Email" name="email" value="<?php 
		

		if (isset($_POST['email'])) 
		{
			echo htmlentities(utf8_decode(trim($_POST['email']))); 
		}
			
		
		
		
		?>" required>
                            </div>

                            <div class="pure-control-group">
                                <label for="pass">Mot de passe *</label>
                                <input type="password" placeholder="Mot de passe" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>" required>

                            </div>
                            <div class="pure-control-group">
                                <label for="pass_confirm">Retaper mot de passe *</label>
                                <input type="password" placeholder="Confirmer Mot de passe" name="pass_confirm" value="<?php if (isset($_POST['pass_confirm'])) echo htmlentities(trim($_POST['pass_confirm'])); ?>" required>

                            </div>

                            <div class="pure-control-group">
                                <label for="telephone">Téléphone *</label>
                                <input type="text" placeholder="Téléphone" name="telephone" value="<?php if (isset($_POST['telephone'])) echo htmlentities(trim($_POST['telephone'])); ?>" required>
                            </div>

                            <div class="pure-control-group">
                                <label for="adresse">Adresse principale *</label>


                                <textarea type="text" placeholder="Adresse" name="adresse"><?php if (isset($_POST['adresse'])) echo htmlentities(utf8_decode(trim($_POST['adresse']))); ?></textarea>

                                <br><br><span class="red"> [ ! ] attention, si vous êtes résident secondaire, commerçant permanent, ou Travailleur/Saisonnier<br> merci d'indiquer votre adresse <strong>principale</strong> [ ! ]</span><br><br>

                            </div>



                            <div class="pure-control-group">
                                <label for="code_postal">Code postal *</label>

                                <input type="text" placeholder="Code postal" name="code_postal" value="<?php if (isset($_POST['code_postal'])) echo htmlentities(utf8_decode(trim($_POST['code_postal']))); ?>" required>

                            </div>
                            <div class="pure-control-group">
                                <label for="ville">Ville *</label>

                                <input type="text" placeholder="Ville" name="ville" value="<?php if (isset($_POST['ville'])) echo htmlentities(utf8_decode(trim($_POST['ville']))); ?>" required>

                            </div>
                            <br><br>










                            <div class="pure-control-group">
                                <label for="adresse2">Adresse secondaire</label>


                                <textarea type="text" placeholder="Adresse secondaire" name="adresse2"><?php if (isset($_POST['adresse2'])) echo htmlentities(utf8_decode(trim($_POST['adresse2']))); ?></textarea>


                            </div>



                            <div class="pure-control-group">
                                <label for="code_postal2">Code postal secondaire</label>

                                <input type="text" placeholder="Code postal secondaire" name="code_postal2" value="<?php if (isset($_POST['code_postal2'])) echo htmlentities(utf8_decode(trim($_POST['code_postal2']))); ?>">

                            </div>
                            <div class="pure-control-group">
                                <label for="ville2">Ville secondaire</label>

                                <input type="text" placeholder="Ville secondaire" name="ville2" value="<?php if (isset($_POST['ville2'])) echo htmlentities(utf8_decode(trim($_POST['ville2']))); ?>">

                            </div>
                            <br><br>



                            <div class="div-tittle">
                                <h4>Votre numéro de carte résident de <span class="color">Megève</span></h4>
                            </div>


                            <br><br><span class="red"> [ ! ] Merci de bien vouloir être vigilant lors de la sélection de votre statut, en cas d'erreur, les forfaits pourront être bloqués [ ! ]</span><br><br>

                            <div class="pure-control-group">
                                <label for="numResident">Numéro *</label>
                                01- <input type="text" name="numResident" value="<?php if (isset($_POST['numResident'])) echo htmlentities(utf8_decode(trim($_POST['numResident']))); ?>" onkeyup="verif_nombre20(this);" onchange="validerTaille(this);" size="20" required> -
                                <input type="text" name="numResident2" value="<?php if (isset($_POST['numResident2'])) echo htmlentities(utf8_decode(trim($_POST['numResident2']))); ?>" onkeyup="verif_nombre1(this);" size="1" required>

                            </div>


                            <div class="pure-control-group">
                                <label for="numResident">Code de sécurité mairie *</label>

                                <input type="text" name="codeMairie" value="<?php if (isset($_POST['codeMairie'])) echo htmlentities(utf8_decode(trim(strtoupper($_POST['codeMairie'])))); ?>" required>

                            </div>



                            <div class="pure-control-group">
                                <label for="typeAdherent">Statut *</label>
                                <select name="typeAdherent">
                                    <option value="RP" <?php if($_POST['typeAdherent']=="RP") echo "selected"; ?>>Résident permanent</option>
                                    <option value="RS" <?php if($_POST['typeAdherent']=="RS") echo "selected"; ?>>Résident secondaire</option>
                                    <option value="TS" <?php if($_POST['typeAdherent']=="TS") echo "selected"; ?>>Travailleur/Saisonnier</option>
                                    <option value="CP" <?php if($_POST['typeAdherent']=="CP") echo "selected"; ?>>Commerçant permanent</option>
                                </select>

                            </div>

                            <br><br>
                            <div class="div-tittle">
                                <h4>Votre photo d'<span class="color">identité</span> (facultatif)</h4>
                            </div>



                            <center>
                                <p>

                                    1. Cliquez sur <img src="images/ajouter.png"> pour ajouter une photo. <br>
                                    2. Veuillez choisir une photo de moins de <strong>700 Ko</strong>, faisant apparaitre vos visage.<br>
                                    2. Vous pouvez la recadrer en zoomant (+), dézoomant (-), etc...<br>
                                    3. <strong><u>N'oubliez pas</u></strong> de cliquer sur <img src="images/confirmer.png"> pour finaliser l'ajout de la photo<br><br><br>


                                <div id="cropContaineroutput"></div>
                                <input type="hidden" id="cropOutput" name="cropOutput" />
                            </center>







                            <div class="hp">
                                <label>Si vous êtes un humain, laissez ce champ vide</label>
                                <input type="text" name="comment">
                            </div>

                            <br><br><br>
                            <div class="div-tittle">
                                <h4>Votre moyen de <span class="color">paiement</span></h4>
                            </div>
                            <div class="choixPaiement">
                                <label for="paiementCB" class="pure-radio">
                                    <input id="paiementCB" type="radio" name="choixPaiement" value="cb" checked>
                                    Payer par <u>CARTE BANCAIRE</u> en ligne (conseillé : votre inscription est instantanée)<br>
                                    <!-- <span style="color:red; font-weight:bold"> ==> Le paiement par CB est momentanément indisponible, veuillez nous en excuser</span>-->

                                </label>
                                <br><br>

                                <label for="paiementCheque" class="pure-radio">
                                    <input id="paiementCheque" type="radio" name="choixPaiement" value="cheque" <?php if($_POST['choixPaiement']=="cheque") echo " checked"; ?>>
                                    Envoyer un <u>CHEQUE de <?php echo $montantAnneeEnCours;?>€ par la poste</u> (votre inscription n'est effective qu'à l'encaissement de votre chèque)
                                </label>
                            </div>

                            <br><br>
                            <center>
                                <span class="msg-error error"></span>
                                <div id="recaptcha" class="g-recaptcha" data-sitekey="6LdC8hcTAAAAALai9tRHxOpbruUt41_BElgMm3aX"></div>
                            </center>
                            <br><br> <br><br>

                            <button type="submit" name="inscription" value="Inscription" class="pure-button primary-button button-success">Valider votre inscription</button>


                        </fieldset>
                    </form>



                </div>
            </div>
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
    <!-- Script Avatar -->
    <script src=" https://code.jquery.com/jquery-2.1.3.min.js"></script>


    <script src="assets/js/jquery.mousewheel.min.js"></script>
    <script src="croppic.min.js"></script>

    <script>
        var croppicHeaderOptions = {
            //uploadUrl:'img_save_to_file.php',
            cropData: {
                "dummyData": 1,
                "dummyData2": "asdas"
            },
            cropUrl: 'img_crop_to_file.php',
            customUploadButtonId: 'cropContainerHeaderButton',
            modal: false,
            processInline: true,
            loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            onBeforeImgUpload: function() {
                console.log('onBeforeImgUpload')
            },
            onAfterImgUpload: function() {
                console.log('onAfterImgUpload')
            },
            onImgDrag: function() {
                console.log('onImgDrag')
            },
            onImgZoom: function() {
                console.log('onImgZoom')
            },
            onBeforeImgCrop: function() {
                console.log('onBeforeImgCrop')
            },
            onAfterImgCrop: function() {
                console.log('onAfterImgCrop')
            },
            onError: function(errormessage) {
                console.log('onError:' + errormessage)
            }
        }
        var croppic = new Croppic('croppic', croppicHeaderOptions);

        var croppicContaineroutputOptions = {
            uploadUrl: 'img_save_to_file.php',
            cropUrl: 'img_crop_to_file.php',
            outputUrlId: 'cropOutput',
            modal: false,
            loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
        }
        var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);

    </script>

</body>


</html>


<?php 
}	
catch(Exception $e)
{
  //$dbh->rollBack();
  echo "Une erreur est survenue. Veuillez ressayer l'opération." ;
  echo $e->getMessage();
}
?>
