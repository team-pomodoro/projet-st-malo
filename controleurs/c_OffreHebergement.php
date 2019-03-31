<?php
// 1ère étape (donc pas d'action choisie) : affichage du tableau des offres en 
// lecture seule
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (empty($action)) {
    $action = 'initial';
}

// Aiguillage selon l'étape   
switch ($action) {
    case 'initial' :
        $nbEtab = $pdo->obtenirNbEtab();
        $nbTypesChambres = $pdo->obtenirNbTypesChambres();
        $lesEtabs = $pdo->obtenirReqIdNomEtablissements();
        include 'vues/OffreHebergement/v_ConsulterOffreHebergement.php';
        break;

    case 'demanderModifierOffre':
        $idEtab = filter_input(INPUT_GET, 'idEtab', FILTER_SANITIZE_STRING);
        $unEtab = $pdo->obtenirDetailEtablissement($idEtab);
        $nom = $unEtab->nom;
        $nbTypesChambres = $pdo->obtenirNbTypesChambres();
        $lesTypesChambres = $pdo->obtenirReqTypesChambres();
        include 'vues/OffreHebergement/v_ModifierOffreHebergement.php';
        break;

    case 'validerModifierOffre':
        $nbEtab = $pdo->obtenirNbEtab();
        $nbTypesChambres = $pdo->obtenirNbTypesChambres();
        $lesEtabs = $pdo->obtenirReqIdNomEtablissements();
        $idEtab = filter_input(INPUT_POST, 'idEtab', FILTER_SANITIZE_STRING);
        $idTypeChambre = filter_input(INPUT_POST, 'idTypeChambre', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
        $nbChambres = filter_input(INPUT_POST, 'nbChambres', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
        $nbLignes = filter_input(INPUT_POST, 'nbLignes', FILTER_SANITIZE_STRING);
        $unEtab = $pdo->obtenirDetailEtablissement($idEtab);
        $nom = $unEtab->nom;
        $lesTypesChambres = $pdo->obtenirReqTypesChambres();
        $err = false;
        for ($i = 0; $i < $nbLignes; $i = $i + 1) {
            // Si la valeur saisie n'est pas numérique ou est inférieure aux 
            // attributions déjà effectuées pour cet établissement et ce type de
            // chambre, la modification n'est pas effectuée
            if (!estEntier($nbChambres[$i]) || !$pdo->estModifOffreCorrecte($idEtab, $idTypeChambre[$i], $nbChambres[$i])) {
                $err = true;
            } else {
                $pdo->modifierOffreHebergement($idEtab, $idTypeChambre[$i], $nbChambres[$i]);
            }
        }
        if ($err) {
            ajouterErreur("Valeurs non entières ou inférieures aux attributions effectuées");
            include 'vues/OffreHebergement/v_ModifierOffreHebergement.php';
        } else {
            include 'vues/OffreHebergement/v_ConsulterOffreHebergement.php';
        }
        break;
}
