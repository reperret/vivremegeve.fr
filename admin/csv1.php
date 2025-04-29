<?php
require_once('phpexcel/Classes/PHPExcel.php');
include '../connexion.php';

$sql = NULL;

if ($_GET['export'] == 1) {
    $annee = date('Y');
    $mois = date('m');
    $anneeSql = ($mois < 9) ? $annee - 1 : $annee;
    $anneeSqlPlus1 = $anneeSql + 1;

    $sql = "
    SELECT
        U.idUtilisateur,
        U.login,
        U.email,
        U.civilite,
        U.typeAdherent,
        U.dateAdhesion,
        R.date,
        U.numAdherent, 
        U.numResident,
        U.nom, 
        U.prenom,
        U.ddn,
        U.adresse,
        U.code_postal,
        U.ville,
        U.telephone,
        U.rgpd_vivre_megeve,
        U.rgpd_mairie_megeve
    FROM utilisateur U 
    LEFT OUTER JOIN renouvellement R 
        ON R.idUtilisateur = U.idUtilisateur 
        AND R.date BETWEEN '" . $anneeSql . "-09-01' AND '" . $anneeSqlPlus1 . "-08-31'  
    WHERE U.renouvellement = 0 
      AND U.paiement = 1
      AND (
        EXISTS (
            SELECT * FROM renouvellement R 
            WHERE U.idUtilisateur = R.idUtilisateur 
            AND R.date BETWEEN '" . $anneeSql . "-09-01' AND '" . $anneeSqlPlus1 . "-08-31'
        ) 
        OR (
            U.datePaiement BETWEEN '" . $anneeSql . "-09-01' AND '" . $anneeSqlPlus1 . "-08-31'  
            AND U.paiement = 1
        )
      )
    ORDER BY nom, prenom
    ";
}

if ($_GET['export'] == 2) {
    $annee = date('Y');
    $mois = date('m');
    $anneeSql = ($mois < 9) ? $annee - 2 : $annee - 1;
    $anneeSqlPlus1 = $anneeSql + 1;

    $sql = "
    SELECT
        U.idUtilisateur,
        U.login,
        U.email,
        U.civilite,
        U.typeAdherent,
        U.dateAdhesion,
        R.date,
        U.numAdherent, 
        U.numResident,
        U.nom, 
        U.prenom,
        U.ddn,
        U.adresse,
        U.code_postal,
        U.ville,
        U.telephone,
        U.rgpd_vivre_megeve,
        U.rgpd_mairie_megeve
    FROM utilisateur U 
    LEFT OUTER JOIN renouvellement R 
        ON R.idUtilisateur = U.idUtilisateur 
        AND R.date BETWEEN '" . $anneeSql . "-09-01' AND '" . $anneeSqlPlus1 . "-08-31'  
    WHERE U.renouvellement = 1 
      AND U.paiement = 1
      AND (
        EXISTS (
            SELECT * FROM renouvellement R 
            WHERE U.idUtilisateur = R.idUtilisateur 
            AND R.date BETWEEN '" . $anneeSql . "-09-01' AND '" . $anneeSqlPlus1 . "-08-31'
        ) 
        OR (
            U.datePaiement BETWEEN '" . $anneeSql . "-09-01' AND '" . $anneeSqlPlus1 . "-08-31'  
            AND U.paiement = 1
        )
      )
    ORDER BY nom, prenom
    ";
}

if ($_GET['export'] == 3) {
    $annee = date('Y');
    $mois = date('m');
    $anneeSql = ($mois < 9) ? $annee - 2 : $annee - 1;
    $anneeSqlPlus1 = $anneeSql + 1;

    $sql = "
    SELECT
        U.idUtilisateur,
        U.login,
        U.email,
        U.civilite,
        U.typeAdherent,
        U.dateAdhesion,
        R.date,
        U.numAdherent, 
        U.numResident,
        U.nom, 
        U.prenom,
        U.ddn,
        U.adresse,
        U.code_postal,
        U.ville,
        U.telephone,
        U.rgpd_vivre_megeve,
        U.rgpd_mairie_megeve
    FROM utilisateur U 
    LEFT OUTER JOIN renouvellement R 
        ON R.idUtilisateur = U.idUtilisateur 
        AND R.date BETWEEN '" . $anneeSql . "-09-01' AND '" . $anneeSqlPlus1 . "-08-31'
    WHERE U.renouvellement = 1 
      AND U.paiement = 1 
      AND NOT EXISTS (
            SELECT * FROM renouvellement R 
            WHERE U.idUtilisateur = R.idUtilisateur 
            AND R.date BETWEEN '" . $anneeSql . "-09-01' AND '" . $anneeSqlPlus1 . "-08-31'
      )
      AND U.dateAdhesion < '" . $anneeSql . "-09-01'
    ORDER BY nom, prenom
    ";
}

// Fonction pour récupérer les données à exporter
function getExports($sql, $dbh)
{
    $enTete = array();
    $export = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($sql);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    $firstForEnTete = true;

    foreach ($lignes as $colonne) {
        $ligneCommande = array();
        $enTete = array();

        $ligneCommande[] = $colonne->idUtilisateur;
        $enTete[] = "idUtilisateur";

        $ligneCommande[] = $colonne->login;
        $enTete[] = "login";

        $ligneCommande[] = $colonne->email;
        $enTete[] = "email";

        $ligneCommande[] = $colonne->civilite;
        $enTete[] = "civilite";

        $ligneCommande[] = $colonne->typeAdherent;
        $enTete[] = "typeAdherent";

        $ligneCommande[] = $colonne->dateAdhesion;
        $enTete[] = "dateAdhesion";

        $ligneCommande[] = $colonne->date;
        $enTete[] = "dateRenouvellement";

        $ligneCommande[] = $colonne->numAdherent;
        $enTete[] = "numAdherent";

        $ligneCommande[] = $colonne->numResident;
        $enTete[] = "numResident";

        $ligneCommande[] = $colonne->nom;
        $enTete[] = "nom";

        $ligneCommande[] = $colonne->prenom;
        $enTete[] = "prenom";

        $ligneCommande[] = $colonne->ddn;
        $enTete[] = "ddn";

        $ligneCommande[] = $colonne->adresse;
        $enTete[] = "adresse";

        $ligneCommande[] = $colonne->code_postal;
        $enTete[] = "code_postal";

        $ligneCommande[] = $colonne->ville;
        $enTete[] = "ville";

        $ligneCommande[] = $colonne->telephone;
        $enTete[] = "telephone";

        // ➡️ Ajout des deux colonnes RGPD
        $ligneCommande[] = $colonne->rgpd_vivre_megeve;
        $enTete[] = "rgpd_vivre_megeve";

        $ligneCommande[] = $colonne->rgpd_mairie_megeve;
        $enTete[] = "rgpd_mairie_megeve";

        if ($firstForEnTete) {
            $export[] = $enTete;
            $firstForEnTete = false;
        }
        $export[] = $ligneCommande;
    }

    return $export;
}

// Génération de l'export
$export = getExports($sql, $dbh);

$doc = new PHPExcel();
$objWorkSheet = $doc->createSheet(0);
$doc->setActiveSheetIndex(0);
$doc->getActiveSheet()->fromArray($export);
$objWorkSheet->setTitle("Adherents");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="export.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
$objWriter->save('php://output');