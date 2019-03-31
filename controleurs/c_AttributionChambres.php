<?php
// 1ère étape (donc pas d'action choisie) : affichage du tableau des 
// attributions en lecture seule
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (empty($action)) {
    $action = 'initial';
}

// Aiguillage selon l'étape
switch ($action) {
    case 'initial':
        $nbEtabOffrantChambres = $pdo->obtenirNbEtabOffrantChambres();
        // POUR CHAQUE ÉTABLISSEMENT : AFFICHAGE D'UN TABLEAU COMPORTANT 2 LIGNES 
        // D'EN-TÊTE (LIGNE NOM ET LIGNE DISPONIBILITÉS) ET LE DÉTAIL DES ATTRIBUTIONS
        $lesEtabsOffrantChambres = $pdo->obtenirReqIdNomEtablissementsOffrantChambres();
        $nbTypesChambres = $pdo->obtenirNbTypesChambres();
        // Détermination du :
        //    . % de largeur que devra occuper chaque colonne contenant les attributions
        //      (100 - 35 pour la colonne d'en-tête) / nb de types chambres
        //    . nombre de colonnes de chaque tableau
        $pourcCol = 65 / $nbTypesChambres;
        $nbCol = $nbTypesChambres + 1;
        include 'vues/AttributionChambres/v_ConsulterAttributionChambres.php';
        break;

    case 'demanderModifierAttrib':
        // EFFECTUER OU MODIFIER LES ATTRIBUTIONS POUR L'ENSEMBLE DES ÉTABLISSEMENTS
        // CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ DE 3 LIGNES D'EN-TÊTE (LIGNE TITRE, 
        // LIGNE ÉTABLISSEMENTS ET LIGNE TYPES DE CHAMBRES) ET DU DÉTAIL DES 
        // ATTRIBUTIONS 
        // UNE LÉGENDE FIGURE SOUS LE TABLEAU
        // Recherche du nombre d'établissements offrant des chambres pour le 
        // dimensionnement des colonnes
        $nbEtabOffrantChambres = $pdo->obtenirNbEtabOffrantChambres();
        // Détermination du pourcentage de largeur des colonnes "établissements"
        $pourcCol = 65 / $nbEtabOffrantChambres;
        // Recherche du nombre de types de chambres pour le dimensionnement des colonnes
        $nbTypesChambres = $pdo->obtenirNbTypesChambres();
        // Calcul du nombre de colonnes du tableau   
        $nbCol = ($nbEtabOffrantChambres * $nbTypesChambres) + 1;
        $lesEtabsOffrantChambres = $pdo->obtenirReqNomEtablissementsOffrantChambres();
        include 'vues/AttributionChambres/v_ModifierAttributionChambres.php';
        break;

    case 'donnerNbChambres':
        $idEtab = filter_input(INPUT_GET, 'idEtab', FILTER_SANITIZE_STRING);
        $idTypeChambre = filter_input(INPUT_GET, 'idTypeChambre', FILTER_SANITIZE_STRING);
        $idGroupe = filter_input(INPUT_GET, 'idGroupe', FILTER_SANITIZE_STRING);
        $nbChambres = filter_input(INPUT_GET, 'nbChambres', FILTER_VALIDATE_INT);
        include 'vues/AttributionChambres/v_DonnerNbChambresAttributionChambres.php';
        break;

    case 'validerModifierAttrib':
        // EFFECTUER OU MODIFIER LES ATTRIBUTIONS POUR L'ENSEMBLE DES ÉTABLISSEMENTS
        // CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ DE 3 LIGNES D'EN-TÊTE (LIGNE TITRE, 
        // LIGNE ÉTABLISSEMENTS ET LIGNE TYPES DE CHAMBRES) ET DU DÉTAIL DES 
        // ATTRIBUTIONS 
        // UNE LÉGENDE FIGURE SOUS LE TABLEAU
        // Recherche du nombre d'établissements offrant des chambres pour le 
        // dimensionnement des colonnes
        $nbEtabOffrantChambres = $pdo->obtenirNbEtabOffrantChambres();
        // Détermination du pourcentage de largeur des colonnes "établissements"
        $pourcCol = 65 / $nbEtabOffrantChambres;
        // Recherche du nombre de types de chambres pour le dimensionnement des colonnes
        $nbTypesChambres = $pdo->obtenirNbTypesChambres();
        // Calcul du nombre de colonnes du tableau   
        $nbCol = ($nbEtabOffrantChambres * $nbTypesChambres) + 1;
        $lesEtabsOffrantChambres = $pdo->obtenirReqNomEtablissementsOffrantChambres();
        $idEtab = filter_input(INPUT_POST, 'idEtab', FILTER_SANITIZE_STRING);
        $idTypeChambre = filter_input(INPUT_POST, 'idTypeChambre', FILTER_SANITIZE_STRING);
        $idGroupe = filter_input(INPUT_POST, 'idGroupe', FILTER_SANITIZE_STRING);
        $nbChambres = filter_input(INPUT_POST, 'nbChambres', FILTER_VALIDATE_INT);
        $pdo->modifierAttribChamb($idEtab, $idTypeChambre, $idGroupe, $nbChambres);
        include 'vues/AttributionChambres/v_ModifierAttributionChambres.php';
        break;
}
