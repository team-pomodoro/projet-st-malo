<?php
// CONSULTER LES OFFRES DE TOUS LES ÉTABLISSEMENTS
// IL FAUT QU'IL Y AIT AU MOINS UN ÉTABLISSEMENT ET UN TYPE CHAMBRE POUR QUE 
// L'AFFICHAGE SOIT EFFECTUÉ

if ($nbEtab != 0 && $nbTypesChambres != 0) {
    // POUR CHAQUE ÉTABLISSEMENT : AFFICHAGE DU NOM ET D'UN TABLEAU COMPORTANT 1
    // LIGNE D'EN-TÊTE ET 1 LIGNE PAR TYPE DE CHAMBRE
    // BOUCLE SUR LES ÉTABLISSEMENTS
    foreach ($lesEtabs as $unEtab) {
        $idEtab = $unEtab['id'];
        $nom = $unEtab['nom'];

        // AFFICHAGE DU NOM DE L'ÉTABLISSEMENT ET D'UN LIEN VERS LE FORMULAIRE DE
        // MODIFICATION

        ?>
        <strong><?= $nom ?></strong><br>
        <a href='?uc=offreHeberge&action=demanderModifierOffre&idEtab=<?= $idEtab ?>'>Modifier</a>

        <table width='45%' cellspacing='0' cellpadding='0' class='tabQuadrille'>
            <?php
            // AFFICHAGE DE LA LIGNE D'EN-TÊTE

            ?>
            <tr class='enTeteTabQuad'>
                <td width='30%'>Type</td>
                <td width='35%'>Capacité</td>
                <td width='35%'>Nombre de chambres</td> 
            </tr>
            <?php
            $lesTypesChambres = $pdo->obtenirReqTypesChambres();

            // BOUCLE SUR LES TYPES DE CHAMBRES (AFFICHAGE D'UNE LIGNE PAR TYPE DE 
            // CHAMBRE AVEC LE NOMBRE DE CHAMBRES OFFERTES DANS L'ÉTABLISSEMENT POUR 
            // LE TYPE DE CHAMBRE)
            foreach ($lesTypesChambres as $unTypeChambre) {
                $idTypeChambre = $unTypeChambre['id'];
                $libelle = $unTypeChambre['libelle'];

                ?>
                <tr class='ligneTabQuad'>
                    <td><?= $idTypeChambre ?></td>
                    <td><?= $libelle ?></td>
                    <?php
                    // On récupère le nombre de chambres offertes pour l'établissement 
                    // et le type de chambre actuellement traités
                    $nbOffre = $pdo->obtenirNbOffre($idEtab, $idTypeChambre);

                    ?>
                    <td><?= $nbOffre ?></td>
                </tr>
                <?php
            }

            ?>
        </table><br>
        <?php
    }
}
