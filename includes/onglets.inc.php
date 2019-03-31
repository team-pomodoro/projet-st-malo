<?php

// Cette fonction est appelée pour la construction de chaque onglet ($i est la 
// position de l'onglet dans la barre)
function construireMenu($nom, $adr, $i)
{
    // On récupère l'adresse de la page
    $url = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL);
    $queryString = filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_STRING);
    if ($queryString !== '') {
        $pageActuelle = substr($url, strrpos($url, '/') + 1) . '?' . $queryString;
    } else {
        $pageActuelle = substr($url, strrpos($url, '/') + 1);
    }

    // Si l'onglet est déjà ouvert, le lien est inactif
    if ($pageActuelle === $adr) {
        // S'il s'agit de l'onglet de gauche, le style est différent car il faut
        // conserver le trait à gauche sinon le trait de gauche est supprimé
        // (afin d'éviter d'avoir une double épaisseur en raison du trait droit
        // de l'onglet précédent)
        if ($i === 1) {
            echo '<li class="ongletOuvertPrem">' . $nom . '</li>';
        } else {
            echo '<li class="ongletOuvert">' . $nom . '</li>';
        }
    } else {
        // S'il s'agit de l'onglet de gauche, le style est différent car il faut 
        // conserver le trait à gauche sinon le trait de gauche est supprimé 
        // (afin d'éviter d'avoir une double épaisseur en raison du trait droit
        // de l'onglet précédent) 
        if ($i === 1) {
            echo '<li class="ongletPrem"><a href="' . $adr . '">' . $nom . '</a></li>';
        } else {
            echo '<li class="onglet"><a href="' . $adr . '">' . $nom . '</a></li>';
        }
    }
}
