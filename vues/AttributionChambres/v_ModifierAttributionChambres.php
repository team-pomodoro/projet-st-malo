<br>
<table width="90%" cellspacing="0" cellpadding="0" class="tabQuadrille">
    <?php
// AFFICHAGE DE LA 1ÈRE LIGNE D'EN-TÊTE

    ?>
    <tr class="enTeteTabQuad">
        <td  colspan="<?= $nbCol ?>"><strong>Effectuer ou modifier les attributions</strong></td>
    </tr>
    <?php
// AFFICHAGE DE LA 2ÈME LIGNE D"EN-TÊTE (ÉTABLISSEMENTS)

    ?>
    <tr class="ligneTabQuad">
        <td rowspan="2">&nbsp;</td>
        <?php
// BOUCLE SUR LES ÉTABLISSEMENTS
        foreach ($lesEtabsOffrantChambres as $unEtabOffrantChambres) {
            $nom = $unEtabOffrantChambres['nom'];
            // La colonne d"en-tête établissement regroupe autant de colonnes 
            // qu"il existe de types de chambres 

            ?>
            <td width="<?= $pourcCol ?>%" colspan="<?= $nbTypesChambres ?>"><center><?= $nom ?></center></td>
    <?php
}

?>
</tr>
    <?php
// AFFICHAGE DE LA 3ÈME LIGNE D'EN-TÊTE (LIGNE AVEC C1, C2, ..., C1, C2, ...)

    ?>
<tr class="ligneTabQuad">
    <?php
    $lesIdEtabsOffrantChambres = $pdo->obtenirReqIdEtablissementsOffrantChambres();

    // BOUCLE BASÉE SUR LE CRITÈRE ÉTABLISSEMENT 
    foreach ($lesIdEtabsOffrantChambres as $unIdEtabOffrantChambres) {
        $idEtab = $unIdEtabOffrantChambres["id"];

        $lesIdTypesChambres = $pdo->obtenirReqIdTypesChambres();

        // BOUCLE BASÉE SUR LES TYPES DE CHAMBRES
        // Pour chaque établissement, on affiche forcément chaque type de 
        // chambre avec un fond gris si le type de chambre n'est pas proposé et
        // avec un fond vert associé au nombre de chambres libres si le type de
        // chambre est proposé et qu'il reste des chambres libres de ce type.
        // Si le type de chambre est proposé dans l'établissement et qu'il ne
        // reste plus de chambres libres de ce type, l'affichage est effectué
        // sans fond particulier
        foreach ($lesIdTypesChambres as $unIdTypeChambre) {
            $idTypeChambre = $unIdTypeChambre['id'];
            $nbOffre = $pdo->obtenirNbOffre($idEtab, $idTypeChambre);
            if ($nbOffre == 0) {
                // Affichage du type de chambre sur fond gris

                ?>
                <td class="absenceOffre"><?= $idTypeChambre ?><br>&nbsp;</td>
                <?php
            } else {
                // Recherche du nombre de chambres occupées pour l'établissement 
                // et le type de chambre courants
                $nbOccup = $pdo->obtenirNbOccup($idEtab, $idTypeChambre);

                // Calcul du nombre de chambres libres
                $nbChLib = $nbOffre - $nbOccup;

                // Pour un établissement et un code type chambre, on affiche le
                // type chambre sur fond vert avec le nombre de chambres libres
                // s'il y a des chambres libres sinon seul le type chambre est 
                // affiché               
                if ($nbChLib != 0) {

                    ?>
                    <td class="libre"><?= $idTypeChambre ?><br><?= $nbChLib ?></td>
                    <?php
                } else {

                    ?>
                    <td class="reserveSiLien"><?= $idTypeChambre ?><br>&nbsp;</td>
                    <?php
                }
            }
        } // Fin de la boucle des types de chambres
    } // Fin de la boucle basée sur le critère établissement

    ?>
</tr>
<?php
// 4ÈME PARTIE : CORPS DU TABLEAU : CONSTITUTION D'UNE LIGNE PAR GROUPE À 
// HÉBERGER AVEC LES CHAMBRES ATTRIBUÉES ET LES LIENS POUR EFFECTUER OU
// MODIFIER LES ATTRIBUTIONS

$lesIdNomGroupesAHeberger = $pdo->obtenirReqIdNomGroupesAHeberger();

// BOUCLE SUR LES GROUPES À HÉBERGER 
foreach ($lesIdNomGroupesAHeberger as $unIdNomGroupeAHeberger) {
    $idGroupe = $unIdNomGroupeAHeberger['id'];
    $nom = $unIdNomGroupeAHeberger['nom'];

    ?>
    <tr class="ligneTabQuad">
        <td align="center" width="25%"><?= $nom ?></td>
        <?php
        $lesIdEtabsOffrantChambres = $pdo->obtenirReqIdEtablissementsOffrantChambres();

        // BOUCLE SUR LES ÉTABLISSEMENTS
        foreach ($lesIdEtabsOffrantChambres as $unIdEtabOffrantChambres) {
            $idEtab = $unIdEtabOffrantChambres["id"];
            $lesIdTypesChambres = $pdo->obtenirReqIdTypesChambres();

            // BOUCLE SUR LES TYPES DE CHAMBRES
            foreach ($lesIdTypesChambres as $unIdTypeChambre) {
                $idTypeChambre = $unIdTypeChambre["id"];
                // Pour chaque cellule, 4 cas possibles :
                // 1) type chambre inexistant dans cet étab : fond gris, 
                // 2) des chambres ont déjà été attribuées au groupe pour cet
                //    étab et ce type de chambre : fond jaune avec le nb de 
                //    chambres attribuées et lien permettant de modifier le nb,
                // 3) aucune chambre du type en question n'a encore été attribuée
                //    au groupe dans cet étab et il n'y a plus de chambres libres
                //    de ce type dans l'étab : cellule vide,
                // 4) aucune chambre du type en question n'a encore été attribuée
                //    au groupe dans cet étab et il reste des chambres libres de 
                //    ce type dans l'établissement : affichage d'un lien pour 
                //    faire une attribution

                $nbOffre = $pdo->obtenirNbOffre($idEtab, $idTypeChambre);
                if ($nbOffre == 0) {
                    // Affichage d'une cellule vide sur fond gris 

                    ?>
                    <td class="absenceOffre">&nbsp;</td>
                    <?php
                } else {
                    $nbOccup = $pdo->obtenirNbOccup($idEtab, $idTypeChambre);

                    // Calcul du nombre de chambres libres
                    $nbChLib = $nbOffre - $nbOccup;

                    // On recherche si des chambres du type en question ont déjà
                    // été attribuées à ce groupe dans cet établissement
                    $nbOccupGroupe = $pdo->obtenirNbOccupGroupe($idEtab, $idTypeChambre, $idGroupe);
                    if ($nbOccupGroupe != 0) {
                        // Le nombre de chambres maximum pouvant être 
                        // demandées est la somme du nombre de chambres 
                        // libres et du nombre de chambres actuellement 
                        // attribuées au groupe
                        $nbMax = $nbChLib + $nbOccupGroupe;

                        ?>

                        <td class="reserve">
                            <a href="?uc=attribChambres&action=donnerNbChambres&idEtab=<?= $idEtab ?>&idTypeChambre=<?= $idTypeChambre ?>&idGroupe=<?= $idGroupe ?>&nbChambres=<?= $nbMax ?>"><?= $nbOccupGroupe ?></a></td>
                        <?php
                    } else {
                        // Cas où il n'y a pas de chambres de ce type 
                        // attribuées à ce groupe dans cet établissement : 
                        // on affiche un lien vers donnerNbChambres s'il y a 
                        // des chambres libres sinon rien n'est affiché     
                        if ($nbChLib != 0) {

                            ?>
                            <td class="reserveSiLien">
                                <a href="?uc=attribChambres&action=donnerNbChambres&idEtab=<?= $idEtab ?>&idTypeChambre=<?= $idTypeChambre ?>&idGroupe=<?= $idGroupe ?>&nbChambres=<?= $nbChLib ?>">__</a></td>
                            <?php
                        } else {

                            ?>
                            <td class="reserveSiLien">&nbsp;</td>
                            <?php
                        }
                    }
                }
            } // Fin de la boucle sur les types de chambres
        } // Fin de la boucle sur les établissements       
    } // Fin de la boucle sur les groupes à héberger

    ?>
</table>
    <?php
// Fin du tableau principal
// AFFICHAGE DE LA LÉGENDE

    ?>
<table width="70%" align=center>
    <tr>
    <br>
    <td class="reserveSiLien" height="10">&nbsp;</td>
    <td width="21%" align="left">Réservation possible si lien affiché</td>
    <td class="absenceOffre" height="10">&nbsp;</td>
    <td width="21%" align="left">Absence d"offre</td>
    <td class="reserve" height="10">&nbsp;</td>
    <td width="21%" align="left">Nombre de places réservées</td>
    <td class="libre" height="10">&nbsp;</td>
    <td width="21%" align="left">Nombre de places encore disponibles</td>
</tr>
</table>
<br><center><a href="?uc=attribChambres">Retour</a></center>
