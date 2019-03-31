<?php
// AFFICHER L'ENSEMBLE DES ÉTABLISSEMENTS
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// ÉTABLISSEMENT

?>
<br>
<table width='55%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>

    <tr class='enTeteTabNonQuad'>
        <td colspan='4'><strong>Etablissements</strong></td>
    </tr>
    <?php
    /* $req = obtenirReqIdNomEtablissements();
      $rsEtab = mysql_query($req, $connexion); */

    // BOUCLE SUR LES ÉTABLISSEMENTS
    foreach ($lesEtabs as $unEtab) {
        $id = $unEtab['id'];
        $nom = $unEtab['nom'];

        ?>
        <tr class="ligneTabNonQuad">
            <td width="52%"><?= $nom ?></td>

            <td width="16%" align="center"> 
                <a href="?uc=gestEtabs&action=detailEtab&id=<?= $id ?>">Voir détail</a>
            </td>

            <td width="16%" align="center"> 
                <a href="?uc=gestEtabs&action=demanderModifierEtab&id=<?= $id ?>">Modifier</a>
            </td>
            <?php
            // S'il existe déjà des attributions pour l'établissement, il faudra
            // d'abord les supprimer avant de pouvoir supprimer l'établissement
            if (!$pdo->existeAttributionsEtab($id)) {

                ?>
                <td width="16%" align="center"> 
                    <a href="?uc=gestEtabs&action=demanderSupprimerEtab&id=<?= $id ?>">Supprimer</a></td>
                <?php
            } else {

                ?>
                <td width="16%">&nbsp; </td>
                <?php
            }

            ?>
        </tr>
        <?php
    }

    ?>
</table>
<br>
<a href="?uc=gestEtabs&action=demanderCreerEtab">
    Création d'un établissement</a >
