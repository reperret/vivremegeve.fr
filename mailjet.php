<?php
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
}

// Exemple d'appel de la fonction avec une pièce jointe
echo sendMail("reperret@hotmail.com", "Ceci est un test avec PJ", "Voici mon contenu", "Test bouton", "https://www.google.fr", "6330280", "ceci est un sujet", "testMail.pdf");
?>
