<?php
require_once("lib/Payplug.php");
$isTest = false;
$parameters = Payplug::loadParameters("contact@vivremegeve.fr", "Vivre!Megeve74", $isTest);
$parameters->saveInFile("parameters.json");
?>