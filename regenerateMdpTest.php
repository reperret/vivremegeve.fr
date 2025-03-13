<?php
try
{
	include('connexion.php');  
    
    
    
    function envoiEmail($emailDestinataire,$emailExpediteur,$nomExpediteur,$numeroTemplate,$tag_titre,$tag_contenu,$tag_lienbouton, $tag_libellebouton,$sujet)
    {

        $url = "https://www.vivremegeve.fr/sendmail/";
        $data = array(
        'emailDestinataire' => $emailDestinataire,
        'emailExpediteur' => $emailExpediteur,
        'nomExpediteur' => $nomExpediteur,
        'numeroTemplate' => $numeroTemplate,
        'tag_titre' => $tag_titre,
        'tag_contenu' => $tag_contenu,
        'tag_lienbouton' => $tag_lienbouton,
        'tag_libellebouton' => $tag_libellebouton,
        'sujet' => $sujet
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    $emailDestinataire="reperret@hotmail.com";
    $emailExpediteur="contact@vivremegeve.fr";
    $nomExpediteur="Vivre Megeve";
    $numeroTemplate="6";
    $tag_titre="Nouveau mot de passe";
    $tag_contenu="Bonjour,<br><br>
    
    Voici votre nouveau mot de passe : ".$newMDPClair."<br>
    Vous pouvez le modifier dès maintenant depuis votre interface adhérent.<br>
    Cordiales salutations.<br><br>
    
    Vivre Megève";
    $tag_lienbouton="https://vivremegeve.fr/seconnecter.php";
    $tag_libellebouton="SE CONNECTER";
    $sujet="votre nouveau mot de passe";
    
    echo "arf";
    echo envoiEmail($emailDestinataire,$emailExpediteur,$nomExpediteur,$numeroTemplate,$tag_titre,$tag_contenu,$tag_lienbouton, $tag_libellebouton,$sujet);
      echo "pouarf";
    
} 
catch (InvalidSignatureException $e) 
{
    mail("reperret@hotmail.com","IPN Failed","The signature was invalid");
}

?>
