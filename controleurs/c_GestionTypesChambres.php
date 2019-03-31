<?php
// 1ère étape (donc pas d'action choisie) : affichage de l'ensemble des types 
// de chambres
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (empty($action)) {
    $action = 'initial';
}

// Aiguillage selon l'étape
switch ($action) {
    case 'initial':
        $lesTypesChambres = $pdo->obtenirReqTypesChambres();
        include 'vues/GestionTypesChambres/v_ObtenirTypesChambres.php';
        break;

    case 'demanderSupprimerTypeChambre':
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        include 'vues/GestionTypesChambres/v_SupprimerTypeChambre.php';
        break;

    case 'demanderCreerTypeChambre':
        // S'il s'agit d'une création et qu'on ne "vient" pas de ce formulaire (on 
        // "vient" de ce formulaire uniquement s'il y avait une erreur), il faut définir 
        // les champs à vide
        $id = '';
        $libelle = '';
        $creation = true;
        $message = "Nouveau type de chambre"; // Alimentation du message de l'en-tête
        $action = "validerCreerTypeChambre";
        include 'vues/GestionTypesChambres/v_CreerModifierTypeChambre.php';
        break;

    case 'demanderModifierTypeChambre':
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        // S'il s'agit d'une modification et qu'on ne "vient" pas de ce formulaire, il
        // faut récupérer le libellé
        $libelle = $pdo->obtenirLibelleTypeChambre($id);
        $creation = false;
        $message = "Type $id";                // Alimentation du message de l'en-tête
        $action = "validerModifierTypeChambre";
        include 'vues/GestionTypesChambres/v_CreerModifierTypeChambre.php';
        break;

    case 'validerSupprimerTypeChambre':
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $pdo->supprimerTypeChambre($id);
        $lesTypesChambres = $pdo->obtenirReqTypesChambres();
        include 'vues/GestionTypesChambres/v_ObtenirTypesChambres.php';
        break;

    case 'validerCreerTypeChambre':
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
        $creation = true;
        $message = "Nouveau type de chambre"; // Alimentation du message de l'en-tête
        verifierDonneesTypeChambreC($id, $libelle);
        if (nbErreurs() == 0) {
            $pdo->creerModifierTypeChambre('C', $id, $libelle);
            $lesTypesChambres = $pdo->obtenirReqTypesChambres();
            include 'vues/GestionTypesChambres/v_ObtenirTypesChambres.php';
        } else {
            include 'vues/GestionTypesChambres/v_CreerModifierTypeChambre.php';
        }
        break;

    case 'validerModifierTypeChambre':
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
        $lesTypesChambres = $pdo->obtenirReqTypesChambres();
        $creation = false;
        $message = 'Type ' . $id;                // Alimentation du message de l'en-tête
        verifierDonneesTypeChambreM($id, $libelle);
        if (nbErreurs() == 0) {
            $pdo->creerModifierTypeChambre('M', $id, $libelle);
            $lesTypesChambres = $pdo->obtenirReqTypesChambres();
            include 'vues/GestionTypesChambres/v_ObtenirTypesChambres.php';
        } else {
            include 'vues/GestionTypesChambres/v_CreerModifierTypeChambre.php';
        }
        break;
}

function verifierDonneesTypeChambreC($id, $libelle)
{
    if ($id === '' || $libelle === '') {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($id !== "") {
        // Si l'id est constitué d'autres caractères que de lettres non accentuées 
        // et de chiffres, une erreur est générée
        if (!estChiffresOuEtLettres($id)) {
            ajouterErreur("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
        }
        /* else
          {
          if ($pdo->estUnIdTypeChambre($id))
          {
          ajouterErreur('Le type de chambre ' . $id . ' existe déjà');
          }
          } */
    }
    /* if ($libelle !== '' && $pdo->estUnLibelleTypeChambre('C', $id, $libelle))
      {
      ajouterErreur('Le type de chambre ' . $libelle . ' existe déjà');
      } */
}

function verifierDonneesTypeChambreM($id, $libelle)
{
    if ($libelle === '') {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    /* if ($libelle !== '' && $pdo->estUnLibelleTypeChambre('M', $id, $libelle))
      {
      ajouterErreur('Le type de chambre ' . $libelle . ' existe déjà');
      } */
}
