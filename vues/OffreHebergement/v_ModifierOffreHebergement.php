<?php
// MODIFIER LES OFFRES DE L'ÉTABLISSEMENT SÉLECTIONNÉ

?>
<form method="POST" action="?uc=offreHeberge&action=validerModifierOffre">
    <?php
    // $i va permettre de manipuler le tableau $nbChambres qui contient 
    // les offres de chambres relatives à tous les types de chambres pour 
    // l'établissement en question
    // $nbChambres[0] contiendra le nombre de chambres pour le 1er type de 
    // chambre, $nbChambres[1] contiendra le nombre de chambres pour le 2ème type  
    // de chambre...
    $i = 0;

    // AFFICHAGE DU NOM DE L"ÉTABLISSEMENT

    ?>
    <br><strong><?= $nom ?></strong><br><br>

    <table width="45%" cellspacing="0" cellpadding="0" class="tabQuadrille">
        <?php
        // AFFICHAGE DE LA LIGNE D"EN-TÊTE

        ?>
        <tr class="enTeteTabQuad">
            <td width="30%">Type</td>
            <td width="37%">Capacité</td>
            <td width="33%">Nombre de chambres</td> 
        </tr>

        <?php
        // BOUCLE SUR LES TYPES DE CHAMBRES (AFFICHAGE D'UNE LIGNE PAR TYPE DE 
        // CHAMBRE AVEC EN 3ÈME COLONNE LE NOMBRE DE CHAMBRES OFFERTES DANS
        // L'ÉTABLISSEMENT POUR LE TYPE DE CHAMBRE OU LA VALEUR EN ERREUR LE CAS
        // ÉCHÉANT)
        foreach ($lesTypesChambres as $unTypeChambre) {
            $idTypeChambre = $unTypeChambre["id"];
            $libelle = $unTypeChambre["libelle"];

            ?>
            <tr class="ligneTabQuad">
                <td><?= $idTypeChambre ?></td>
                <td><?= $libelle ?></td>
                <?php
                // AFFICHAGE DE LA CELLULE NOMBRE DE CHAMBRES OFFERTES
                // Si on "vient" de ce formulaire (action "validerModifierOffre") et
                // que le nombre de chambres pour le type en question est en erreur,
                // ce nombre est affiché en erreur
                if ($action === "validerModifierOffre" && (!estEntier($nbChambres[$i]) || !$pdo->estModifOffreCorrecte($idEtab, $idTypeChambre, $nbChambres[$i]))) {

                    ?>
                    <td align="center"><input type="text" value="<?= $nbChambres[$i] ?>" name="nbChambres[<?= $i ?>]" maxlength="3" class="erreur"></td>
                        <?php
                    } else {
                        // Appel à la fonction obtenirNbOffre pour récupérer le nombre
                        // de chambres offertes
                        $nbOffre = $pdo->obtenirNbOffre($idEtab, $idTypeChambre);

                        ?>
                    <td align="center"><input type="text" value="<?= $nbOffre ?>" name="nbChambres[<?= $i ?>]" maxlength="3"></td>
                    <?php
                }
                // Le tableau des différents $idTypeChambre est nécessaire à
                // c_OffreHebergement.php donc on le transmet en champs cachés

                ?>
            <input type="hidden" value="<?= $idTypeChambre ?>" name="idTypeChambre[<?= $i ?>]">
            </tr>
            <?php
            $i = $i + 1;
        } // Fin de la boucle sur les types de chambres

        ?>
    </table>
    <?php
    // La variable $idEtab et le nombre de lignes du tableau (qui est en fait le
    // nombre de types de chambres) sont nécessaires àc_OffreHebergement.php donc 
    // on les transmet en champs cachés

    ?>
    <input type="hidden" value="<?= $idEtab ?>" name="idEtab">    
    <input type="hidden" value="<?= $i ?>" name="nbLignes">

    <table align="center" cellspacing="15" cellpadding="0">
        <tr>
            <td align="right"><input type="submit" value="Valider" name="validerModifierOffre"></td>
            <td align="left"><input type="reset" value="Annuler" name="annuler"></td>
        </tr>
    </table>
    <a href="?uc=offreHeberge">Retour</a>
</form>
