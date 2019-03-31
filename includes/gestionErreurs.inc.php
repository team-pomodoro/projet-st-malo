<?php

// Si la valeur transmise ne contient pas d'autres caractères que des chiffres, 
// la fonction retourne vrai
function estEntier($valeur)
{
    return !preg_match('/[^0-9]/', $valeur);
}

// Si la valeur transmise ne contient pas d'autres caractères que des chiffres  
// et des lettres non accentuées, la fonction retourne vrai
function estChiffresOuEtLettres($valeur)
{
    return !preg_match('/[^a-zA-Z0-9]/', $valeur);
}

function razErreurs()
{
    unset($_REQUEST['erreurs']);
}

function ajouterErreur($msg)
{
    if (!isset($_REQUEST['erreurs']))
        $_REQUEST['erreurs'] = array();
    $_REQUEST['erreurs'][] = htmlentities($msg, ENT_QUOTES, 'UTF-8');
}

function getErreurs()
{
    if (!isset($_REQUEST['erreurs']))
        $_REQUEST['erreurs'] = array();
    return $_REQUEST['erreurs'];
}

function nbErreurs()
{
    return count(getErreurs());
}

function printErreurs()
{
    if (nbErreurs() != 0) {
        echo '<div id="erreur" class="msgErreur">';
        echo '<ul>';
        foreach (getErreurs() as $erreur) {
            echo "<li>$erreur</li>";
        }
        echo '</ul>';
        echo '</div>';
    }
}

function verifierDonneesEtabC($id, $nom, $adresseRue, $codePostal, $ville, $tel,
    $nomResponsable)
{
    if ($id == "" || $nom == "" || $adresseRue == "" || $codePostal == "" ||
        $ville == "" || $tel == "" || $nomResponsable == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($id != "") {
        // Si l'id est constitué d'autres caractères que de lettres non accentuées 
        // et de chiffres, une erreur est générée
        if (!estChiffresOuEtLettres($id)) {
            ajouterErreur
                ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
        } else {
            /* if (estUnIdEtablissement($id))
              {
              ajouterErreur("L'établissement $id existe déjà");
              } */
        }
    }
    /* if ($nom != "" && estUnNomEtablissement('C', $id, $nom))
      {
      ajouterErreur("L'établissement $nom existe déjà");
      } */
    if ($codePostal != "" && !estUnCp($codePostal)) {
        ajouterErreur('Le code postal doit comporter 5 chiffres');
    }
}

function verifierDonneesEtabM($id, $nom, $adresseRue, $codePostal, $ville, $tel,
    $nomResponsable)
{
    if ($nom == "" || $adresseRue == "" || $codePostal == "" || $ville == "" ||
        $tel == "" || $nomResponsable == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    /* if ($nom != "" && estUnNomEtablissement('M', $id, $nom))
      {
      ajouterErreur("L'établissement $nom existe déjà");
      } */
    if ($codePostal != "" && !estUnCp($codePostal)) {
        ajouterErreur('Le code postal doit comporter 5 chiffres');
    }
}

function estUnCp($codePostal)
{
    // Le code postal doit comporter 5 chiffres
    return strlen($codePostal) == 5 && estEntier($codePostal);
}
