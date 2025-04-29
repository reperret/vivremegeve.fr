<?php
try {
	include('connexion.php');
	session_start();

	//**************VERIFICATION ADMIN DEBUT**********************
	if (!isset($_SESSION['login'])) {
		header('Location: seconnecter.php');
		exit();
	}

	$prenom = "";
	$idUtilisateur = NULL;

	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT prenom, idUtilisateur From utilisateur WHERE login LIKE "' . $_SESSION['login'] . '"');
	$lignes = $resultats->fetchAll(PDO::FETCH_OBJ);

	foreach ($lignes as $colonne) {
		$prenom = $colonne->prenom;
		$idUtilisateur = $colonne->idUtilisateur;
	}
	$resultats->closeCursor();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Association Vivre Megève</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" type="image/x-icon" href="http://www.vivremegeve.fr/vivremegeve3/favicon.ico">
    <script type="text/javascript" src="js/modernizr-2.7.1.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css"
        integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">

    <style type="text/css">
    @media screen and (max-width: 1200px) {
        .div-dobule.x-2 {
            padding-right: 100px;
        }
    }
    </style>
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
                    <h3>Modification de vos informations personnelles</h3>
                </div>
            </div>
        </div>

        <div class="w-section section s-2">
            <div class="w-container">


                <div class="center">


                    <?php $sql = 'SELECT * FROM utilisateur WHERE idUtilisateur=' . $idUtilisateur;

						$resultats = $dbh->query($sql);
						$lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
						?>
                    <?php
						foreach ($lignes as $colonne) {
							$loginToEdit = $colonne->login;
							$email = $colonne->email;
							$civilite = $colonne->civilite;
							$nom = $colonne->nom;
							$prenom = $colonne->prenom;
							$adresse = $colonne->adresse;
							$code_postal = $colonne->code_postal;
							$ville = $colonne->ville;
							$telephone = $colonne->telephone;
							$adminRecup = $colonne->admin;
							$typeAdherent = $colonne->typeAdherent;
							$ddn = $colonne->ddn;
						}
						$resultats->closeCursor();


						$date = new DateTime($ddn);
						$jour = $date->format('d');
						$mois = $date->format('m');
						$annee = $date->format('Y');

						?>

                    <form class="pure-form pure-form-aligned" action="editerMembrePost.php" method="post">
                        <fieldset>
                            <div class="pure-control-group">
                                <label for="civilite">Civilite</label>

                                <input id="option-two" type="radio" name="civilite" value="Monsieur"
                                    <?php if ($civilite == "Monsieur") echo "checked"; ?>>
                                Homme


                                <input id="option-three" type="radio" name="civilite" value="Madame"
                                    <?php if ($civilite == "Madame") echo "checked"; ?>>
                                Femme

                            </div>

                            <!--   <div class="pure-control-group">
            <label for="typeAdherent">Statut *</label>
         <select name="typeAdherent">
        
            <option value="RP" <?php // if($typeAdherent=="RP"){ echo "selected";} 
								?>>Résident permanent</option>
            <option value="RS" <?php //if($typeAdherent=="RS"){ echo "selected";} 
								?>>Résident secondaire</option>
            <option value="TS" <?php //if($typeAdherent=="TS"){ echo "selected";} 
								?>>Travailleur/Saisonnier</option>
        </select>
  
        </div> 
-->

                            <div class="pure-control-group">
                                <label for="state">Email</label>


                                <input type="text" placeholder="Login" name="email" value="<?php echo $email; ?>">
                            </div>


                            <div class="pure-control-group">
                                <label for="state">Mot de passe</label>


                                <input type="password" placeholder="Mot de passe" name="pass"
                                    value="MPD_IMPROBABLEHUHUHU">
                            </div>

                            <div class="pure-control-group">
                                <label for="state">Confirmer MDP</label>


                                <input type="password" placeholder="Confirmer Mot de passe" name="pass_confirm"
                                    value="MPD_IMPROBABLEHUHUHU">
                            </div>



                            <div class="pure-control-group">
                                <label for="nom">Nom</label>


                                <input type="text" placeholder="Nom" name="nom" value="<?php echo $nom; ?>">
                            </div>

                            <div class="pure-control-group">
                                <label for="prenom">Prénom</label>


                                <input type="text" placeholder="Prénom" name="prenom" value="<?php echo $prenom; ?>">
                            </div>


                            <div class="pure-control-group">
                                <label for="ddn">Date de naissance *</label>
                                <select name="jour" style="width:60px">

                                    <?php
										for ($i = 1; $i <= 31; $i++) {
										?>

                                    <option value="<?php echo $i; ?>" <?php if ($jour == $i) {
																					echo "selected";
																				} ?>><?php echo $i; ?></option>

                                    <?php

										}
										?>

                                </select>
                                <select name="mois" style="width:80px">
                                    <option value="1" <?php if ($mois == "1") {
																echo "selected";
															} ?>>Janvier</option>
                                    <option value="2" <?php if ($mois == "2") {
																echo "selected";
															} ?>>Février</option>
                                    <option value="3" <?php if ($mois == "3") {
																echo "selected";
															} ?>>Mars</option>
                                    <option value="4" <?php if ($mois == "4") {
																echo "selected";
															} ?>>Avril</option>
                                    <option value="5" <?php if ($mois == "5") {
																echo "selected";
															} ?>>Mai</option>
                                    <option value="6" <?php if ($mois == "6") {
																echo "selected";
															} ?>>Juin</option>
                                    <option value="7" <?php if ($mois == "7") {
																echo "selected";
															} ?>>Juillet</option>
                                    <option value="8" <?php if ($mois == "8") {
																echo "selected";
															} ?>>Août</option>
                                    <option value="9" <?php if ($mois == "9") {
																echo "selected";
															} ?>>Septembre</option>
                                    <option value="10" <?php if ($mois == "10") {
																echo "selected";
															} ?>>Octobre</option>
                                    <option value="11" <?php if ($mois == "11") {
																echo "selected";
															} ?>>Novembre</option>
                                    <option value="12" <?php if ($mois == "12") {
																echo "selected";
															} ?>>Décembre</option>

                                </select>
                                <select name="annee" style="width:80px">

                                    <?php
										for ($i = 1900; $i <= date("Y"); $i++) {
										?>

                                    <option value="<?php echo $i; ?>" <?php if ($annee == $i) {
																					echo "selected";
																				} ?>><?php echo $i; ?></option>

                                    <?php

										}
										?>
                                </select>
                            </div>



                            <div class="pure-control-group">
                                <label for="adresse">Adresse</label>


                                <textarea name="adresse"
                                    value="<?php echo $adresse; ?>"><?php echo $adresse; ?></textarea>
                            </div>

                            <div class="pure-control-group">
                                <label for="code_postal">Code Postal</label>


                                <input type="text" placeholder="Code Postal" name="code_postal"
                                    value="<?php echo $code_postal; ?>">
                            </div>

                            <div class="pure-control-group">
                                <label for="ville">Ville</label>

                                <input type="text" placeholder="Ville" name="ville" value="<?php echo $ville; ?>">
                            </div>


                            <div class="pure-control-group">
                                <label for="telephone">Téléphone</label>


                                <input type="tel" maxlength="10" placeholder="Téléphone" name="telephone"
                                    value="<?php echo $telephone; ?>">
                            </div>

                            <div class="pure-control-group">
                                <label for="rgpd_vivre_megeve">Consentement Vivre Megève</label>
                                <input type="checkbox" name="rgpd_vivre_megeve" value="1"
                                    <?php if ($colonne->rgpd_vivre_megeve == 1) echo "checked"; ?>>
                            </div>

                            <div class="pure-control-group">
                                <label for="rgpd_mairie_megeve">Consentement Forfaits/Mairie</label>
                                <input type="checkbox" name="rgpd_mairie_megeve" value="1"
                                    <?php if ($colonne->rgpd_mairie_megeve == 1) echo "checked"; ?>>
                            </div>



                            <br />
                            <input type="hidden" name="idToEdit" value="<?php echo $idUtilisateur; ?>">

                            <button type="submit" class="button-violet pure-button" name="inscription"
                                value="Inscription">METTRE A JOUR</button>

                        </fieldset>
                    </form>


                </div>
            </div>
        </div>







    </div>







    <footer class="w-section footer">
        <div class="bottom-footer">
            <div class="w-container cont-center">
                <p class="p-footer">Création du site : <a href="http://www.remyperret.com" target="_blank">Rémy PERRET
                    </a></p>
            </div>
        </div>

        <div class="w-container">

            <div class="w-row">
                <div class="w-col w-col-8 col-spc">
                    <div>
                        <h1 class="top-footer">A propos de l'association</h1>
                    </div>
                    <div class="div-spc">
                        <p><em><strong>Association</strong> de type loi "1901" crée à titre non lucratif avec pour
                                objectif de représenter, défendre et informer ses membres en leur qualité d'usager des
                                Services Publics Industriels et Commerciaux (SPIC)<br></em></p>
                    </div>
                </div>



                <div class="w-col w-col-4">
                    <div>
                        <h1 class="top-footer">Contact info</h1>
                    </div>
                    <div class="div-spc">
                        <p> <strong>Email:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;contact@vivremegeve.fr<br><strong>Adresse:</strong>&nbsp;&nbsp;&nbsp;&nbsp;Tour
                            MAGDELAIN, 28, place de l'église
                            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;74120
                            MEGEVE&nbsp;
                        </p>
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


<?php
} catch (Exception $e) {
	$dbh->rollBack();
	echo "Une erreur est survenue. Veuillez cliquez <a href=\"javascript:history.back()\">ici</a>et ressayer l'opération.";
	echo $e->getMessage();
}
?>