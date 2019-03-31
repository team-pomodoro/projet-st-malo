<?php
require_once 'includes/gestionErreurs.inc.php';
require_once 'modele/class.pdofestival.inc.php';
include 'includes/pdo-debug.php';

$pdo = PdoFestival::getPdoFestival();

require 'vues/v_debut.inc.php';

$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
if (empty($uc)) {
    $uc = 'accueil';
}
switch ($uc) {
    case 'accueil':
        include 'vues/Accueil/v_Accueil.php';
        break;
    case 'gestEtabs':
        include './controleurs/c_GestionEtablissements.php';
        break;
    case 'gestTypesChambres':
        include './controleurs/c_GestionTypesChambres.php';
        break;
    case 'offreHeberge':
        include './controleurs/c_OffreHebergement.php';
        break;
    case 'attribChambres':
        include './controleurs/c_AttributionChambres.php';
        break;
}
require 'vues/v_fin.inc.php';
