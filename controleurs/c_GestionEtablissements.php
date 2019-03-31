<?php
// 1ère étape (donc pas d'action choisie) : affichage du tableau des 
// établissements 
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (empty($action)) {
    $action = 'initial';
}

// Aiguillage selon l'étape
switch ($action) {
    case 'initial' :
        $lesEtabs = $pdo->obtenirReqIdNomEtablissements();
        include 'vues/GestionEtablissements/v_ObtenirEtablissements.php';
        break;

    case 'detailEtab':
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $unEtab = $pdo->obtenirDetailEtablissement($id);
        include 'vues/GestionEtablissements/v_ObtenirDetailEtablissement.php';
        break;

    case 'demanderSupprimerEtab':
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $unEtab = $pdo->obtenirDetailEtablissement($id);
        include 'vues/GestionEtablissements/v_SupprimerEtablissement.php';
        break;

    case 'demanderCreerEtab':
        $creation = true;
        $message = "Nouvel établissement";  // Alimentation du message de l'en-tête
        $action = "validerCreerEtab";
        // Déclaration du tableau des civilités
        $tabCivilite = array("Monsieur", "Madame", "Mademoiselle");
        include 'vues/GestionEtablissements/v_CreerModifierEtablissement.php';
        break;

    case 'demanderModifierEtab':
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $unEtab = $pdo->obtenirDetailEtablissement($id);
        $creation = false;
        $message = $unEtab->nom . ' (' . $unEtab->id . ')'; // Alimentation du message de l'en-tête
        $action = "validerModifierEtab";
        // Déclaration du tableau des civilités
        $tabCivilite = array("Monsieur", "Madame", "Mademoiselle");
        include 'vues/GestionEtablissements/v_CreerModifierEtablissement.php';
        break;

    case 'validerSupprimerEtab':
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $pdo->supprimerEtablissement($id);
        $lesEtabs = $pdo->obtenirReqIdNomEtablissements();
        include 'vues/GestionEtablissements/v_ObtenirEtablissements.php';
        break;

    case 'validerCreerEtab':case 'validerModifierEtab':
        $creation = true;
        $message = "Nouvel établissement";  // Alimentation du message de l'en-tête
        // Déclaration du tableau des civilités
        $tabCivilite = array("Monsieur", "Madame", "Mademoiselle");
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
        $adresseRue = filter_input(INPUT_POST, 'adresseRue', FILTER_SANITIZE_STRING);
        $codePostal = filter_input(INPUT_POST, 'codePostal', FILTER_SANITIZE_STRING);
        $ville = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_STRING);
        $tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);
        $adresseElectronique = filter_input(INPUT_POST, 'adresseElectronique', FILTER_SANITIZE_STRING);
        $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
        $civiliteResponsable = filter_input(INPUT_POST, 'civiliteResponsable', FILTER_SANITIZE_STRING);
        $nomResponsable = filter_input(INPUT_POST, 'nomResponsable', FILTER_SANITIZE_STRING);
        $prenomResponsable = filter_input(INPUT_POST, 'prenomResponsable', FILTER_SANITIZE_STRING);

        if ($action === 'validerCreerEtab') {
            verifierDonneesEtabC($id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable);
            if (nbErreurs() === 0) {
                $pdo->creerModifierEtablissement('C', $id, $nom, $adresseRue, $codePostal,
                    $ville, $tel, $adresseElectronique, $type,
                    $civiliteResponsable, $nomResponsable,
                    $prenomResponsable);
                $lesEtabs = $pdo->obtenirReqIdNomEtablissements();
                include 'vues/GestionEtablissements/v_ObtenirEtablissements.php';
            } else {
                $lesEtabs = $pdo->obtenirReqIdNomEtablissements();
                include 'vues/GestionEtablissements/v_CreerModifierEtablissement.php';
            }
        } else {
            verifierDonneesEtabM($id, $nom, $adresseRue, $codePostal, $ville, $tel,
                $nomResponsable);
            if (nbErreurs() === 0) {
                $pdo->creerModifierEtablissement('M', $id, $nom, $adresseRue, $codePostal,
                    $ville, $tel, $adresseElectronique, $type,
                    $civiliteResponsable, $nomResponsable,
                    $prenomResponsable);
                $lesEtabs = $pdo->obtenirReqIdNomEtablissements();
                include 'vues/GestionEtablissements/v_ObtenirEtablissements.php';
            } else {
                $lesEtabs = $pdo->obtenirReqIdNomEtablissements();
                include 'vues/GestionEtablissements/v_CreerModifierEtablissement.php';
            }
        }
        break;
}


