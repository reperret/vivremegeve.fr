<?php 
//Domaine

$montantAnneeEnCours=8;
//$couleurCarte='#33ab54'; //2017
//$couleurCarte='#b8172d'; //2018
//$couleurCarte='#5b298e'; //2019
//$couleurCarte='#da1678';   //2020
//$couleurCarte='#01bdf2';   //2021
//$couleurCarte='#eacd33';   //2022
//$couleurCarte='#7EAD82';   //2023
$couleurCarte='#66463C';   //2024




$domaine="https://www.vivremegeve.fr/";

//Adresses Email
$emailAlerteSem="resp-caisse.ro@ski.megeve.com";
$emailContact="contact@vivremegeve.fr";
$emailWebmasterAlerte="reperret@hotmail.com";

$CSVhost="vivremsbdd.mysql.db";
$CSVuname="vivremsbdd";
$CSVpass="VivreMegeve74";
$CSVdatabase = "vivremsbdd"; 
/*

$CSVhost="localhost";
$CSVuname="root";
$CSVpass="Deflagratione89";
$CSVdatabase = "vivremegeve"; */
 



try 
{
	$dbh = new PDO('mysql:dbname='.$CSVdatabase.';host='.$CSVhost, $CSVuname,$CSVpass);
} 
catch (Exception $e) 
{
  die("Impossible de se connecter: " . $e->getMessage());
}


function upload($nomInputFile)
{
    $target_dir=NULL;
    $target_dir='../actualites/';

    $ext = pathinfo($_FILES[$nomInputFile]["name"], PATHINFO_EXTENSION);
    $nomFichier=rand(0,999)."_".time().".".$ext;
    $target_file = $target_dir.$nomFichier;
    $enregistrement=move_uploaded_file($_FILES[$nomInputFile]["tmp_name"], $target_file);
    
    if($enregistrement)
    {
        return $nomFichier;
    }
    else
    {
        return false;
    }

}


function verifierCodeMairie($codeMairie,$dbh)
{
    $sql= "select count(*) as trouve from code where valeurCode='".trim($codeMairie)."' and dateUtilisationCode IS NULL and idUtilisateur IS NULL";
	$resultats = $dbh->query($sql);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	
	$dbh->query("SET NAMES 'utf8'");
	$trouve=false;
	foreach ($lignes as $colonne)
	{
		$trouve=$colonne->trouve;
	}
    if($trouve==1) $trouve=true;
	
	return $trouve;
}

/*
function sendMail($email, $titre, $contenu, $libelleBouton, $lienBouton, $template, $sujet, $fichierPath = null)
{
    // Importer les variables globales
    $expediteurMailjet="contact@vivremegeve.fr";
    $apiKeyMailjet="5836955ec62772c92e606d3abaec4b6b";
    $apiSecretMailjet="2af83dca15d562c1c6904a26be6ecc82";
    $nomExpediteurMailjet="Vivre Megève";

    // Récupérer les variables depuis les paramètres ou les variables globales
    $apiKey = $apiKeyMailjet;
    $apiSecret = $apiSecretMailjet;
    $templateId = intval($template);
    $emetteur = $expediteurMailjet;
    $nomEmetteur = $nomExpediteurMailjet;

    $destinataire = $email;
    $nomDestinataire = ''; // Vous pouvez ajouter un paramètre pour le nom du destinataire si nécessaire

    // Vérifier que toutes les variables requises sont présentes
    if (!$apiKey || !$apiSecret || !$templateId || !$emetteur || !$nomEmetteur || !$destinataire || !$sujet) {
        return false;
    }

    // Préparer les variables pour le template
    $variables = [
        "titre" => $titre,
        "corpsTexte" => $contenu,
        "libelleBouton" => $libelleBouton,
        "lienBouton" => $lienBouton,
    ];

    // Préparer la pièce jointe si un fichier est fourni
    $attachments = [];
    if ($fichierPath && file_exists($fichierPath)) {
        $fileContent = file_get_contents($fichierPath);
        $encodedFile = base64_encode($fileContent);
        $attachments[] = [
            'ContentType' => mime_content_type($fichierPath),
            'Filename' => basename($fichierPath),
            'Base64Content' => $encodedFile
        ];
    }

    // Préparer le contenu de l'email avec le template et la pièce jointe
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => $emetteur,
                    'Name' => $nomEmetteur
                ],
                'To' => [
                    [
                        'Email' => $destinataire,
                        'Name' => $nomDestinataire
                    ]
                ],
                'TemplateID' => $templateId,
                'TemplateLanguage' => true,
                'Subject' => $sujet,
                'Variables' => $variables,
                'CustomID' => "MonEmailTemplate",
                // Ajout des pièces jointes
                'Attachments' => $attachments
            ]
        ]
    ];

    // Convertir le corps en JSON
    $bodyJson = json_encode($body);

    // Initialiser cURL
    $ch = curl_init();

    // Configurer cURL
    curl_setopt($ch, CURLOPT_URL, 'https://api.mailjet.com/v3.1/send');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyJson);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':' . $apiSecret);

    // Exécution de la requête et récupération de la réponse
    $response = curl_exec($ch);

    // Vérification des erreurs cURL
    if (curl_errno($ch)) {
        curl_close($ch);
        return false;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $responseData = json_decode($response, true);

    curl_close($ch);

    // Vérifier la réponse de l'API Mailjet
    if ($httpCode == 200 && isset($responseData['Messages'])) {
        $messageStatus = $responseData['Messages'][0]['Status'];

        if ($messageStatus == 'success') {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}*/

function sendMail($email, $titre, $contenu, $libelleBouton, $lienBouton, $template, $sujet, $fichierPath = null)
{
    $expediteurMailjet = "contact@vivremegeve.fr";
    $apiKeyMailjet = "5836955ec62772c92e606d3abaec4b6b";
    $apiSecretMailjet = "2af83dca15d562c1c6904a26be6ecc82";
    $nomExpediteurMailjet = "Vivre Megève";

    // Variables de l'API Mailjet
    $apiKey = $apiKeyMailjet;
    $apiSecret = $apiSecretMailjet;
    $templateId = intval($template);
    $emetteur = $expediteurMailjet;
    $nomEmetteur = $nomExpediteurMailjet;

    $destinataire = $email;
    $nomDestinataire = '';

    // Vérification des variables essentielles
    if (!$apiKey || !$apiSecret || !$templateId || !$emetteur || !$nomEmetteur || !$destinataire || !$sujet) {
        return false;
    }

    // Extraction de l'email du contenu
    $extractedEmail = extractEmailFromContent($contenu);

    // Préparer les variables du template
    $variables = [
        "titre" => $titre,
        "corpsTexte" => $contenu,
        "libelleBouton" => $libelleBouton,
        "lienBouton" => $lienBouton,
    ];

    $attachments = [];
    if ($fichierPath && file_exists($fichierPath)) {
        $fileContent = file_get_contents($fichierPath);
        $encodedFile = base64_encode($fileContent);
        $attachments[] = [
            'ContentType' => mime_content_type($fichierPath),
            'Filename' => basename($fichierPath),
            'Base64Content' => $encodedFile
        ];
    }

    // Construction de l'email avec le template et pièces jointes
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => $emetteur,
                    'Name' => $nomEmetteur
                ],
                'To' => [
                    [
                        'Email' => $destinataire,
                        'Name' => $nomDestinataire
                    ]
                ],
                'TemplateID' => $templateId,
                'TemplateLanguage' => true,
                'Subject' => $sujet,
                'Variables' => $variables,
                'CustomID' => "MonEmailTemplate",
                'Attachments' => $attachments
            ]
        ]
    ];

    // Ajouter l'en-tête Reply-To avec l'email extrait du contenu si disponible
    if ($extractedEmail) {
        $body['Messages'][0]['ReplyTo'] = [
            'Email' => $extractedEmail,
            'Name' => ''
        ];
    }

    // Conversion en JSON
    $bodyJson = json_encode($body);

    // Initialisation de cURL
    $ch = curl_init();

    // Configuration de cURL
    curl_setopt($ch, CURLOPT_URL, 'https://api.mailjet.com/v3.1/send');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyJson);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':' . $apiSecret);

    // Exécution de la requête et récupération de la réponse
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return false;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $responseData = json_decode($response, true);

    curl_close($ch);

    // Vérification de la réponse de l'API Mailjet
    if ($httpCode == 200 && isset($responseData['Messages'])) {
        $messageStatus = $responseData['Messages'][0]['Status'];

        return $messageStatus == 'success';
    } else {
        return false;
    }
}

// Fonction pour extraire l'adresse email du contenu
function extractEmailFromContent($contenu) {
    // Regex pour détecter l'email dans le contenu
    $pattern = '/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}\b/i';

    // Rechercher toutes les correspondances
    preg_match($pattern, $contenu, $matches);

    // Retourner le premier email trouvé, ou null si pas d'email
    return $matches[0] ?? null;
}



?>
