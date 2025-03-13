<?php 
include('connexion.php'); 
include('generationCarteAdherentFonction.php');
generateCarteUtilisateur($_GET['idU'], $_GET['action'], $_GET['numAdherent'],$dbh) ;


?>