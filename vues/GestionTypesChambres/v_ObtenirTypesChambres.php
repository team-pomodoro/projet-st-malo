<?php
// AFFICHER L'ENSEMBLE DES TYPES DE CHAMBRES 
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR 
// TYPE DE CHAMBRE

?>

<br>
<table width="40%" cellspacing="0" cellpadding="0" class="tabNonQuadrille">
    <tr class="enTeteTabNonQuad">
        <td colspan="4"><strong>Types de chambres</strong></td>
    </tr>
    <?php
    // BOUCLE SUR LES TYPES DE CHAMBRES
    foreach ($lesTypesChambres as $unTypeChambre) {
        $id = $unTypeChambre['id'];
        $libelle = $unTypeChambre['libelle'];

        ?>
        <tr class="ligneTabNonQuad"> 
            <td width="15%"><?= $id ?></td>
            <td width="33%"><?= $libelle ?></td>
            <td width="26%" align="center">
                <a href="?uc=gestTypesChambres&action=demanderModifierTypeChambre&id=<?= $id ?>">Modifier</a>
            </td>
            <?php
            // S"il existe déjà des attributions pour le type de chambre, il faudra
            // d"abord les supprimer avant de pouvoir supprimer le type de chambre
            if (!$pdo->existeAttributionsTypeChambre($id)) {

                ?>
                <td width="26%" align="center">
                    <a href="?uc=gestTypesChambres&action=demanderSupprimerTypeChambre&id=<?= $id ?>">Supprimer</a>
                </td>
                <?php
            } else {

                ?>
                <td width="26%">&nbsp; </td>
                <?php
            }

            ?>
        </tr>
        <?php
    }

    ?>
</table><br>
<a href="?uc=gestTypesChambres&action=demanderCreerTypeChambre">Création d'un type de chambre</a>
