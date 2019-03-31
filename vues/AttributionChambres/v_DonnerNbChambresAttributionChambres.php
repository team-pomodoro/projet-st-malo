<?php
// SÉLECTIONNER LE NOMBRE DE CHAMBRES SOUHAITÉES

?>
<form method='POST' action='?uc=attribChambres&action=validerModifierAttrib'>
    <input type='hidden' value='<?= $idEtab ?>' name='idEtab'>
    <input type='hidden' value='<?= $idTypeChambre ?>' name='idTypeChambre'>
    <input type='hidden' value='<?= $idGroupe ?>' name='idGroupe'>
    <?php
    $nomGroupe = $pdo->obtenirNomGroupe($idGroupe);

    ?>
    <br><center>Combien de chambres de type <?= $idTypeChambre ?> souhaitez-vous pour le groupe <?= $nomGroupe ?> ?<br><br><br>
        <select name='nbChambres'>
            <?php
            for ($i = 0; $i <= $nbChambres; $i++) {

                ?>
                <option><?= $i ?></option>
                <?php
            }

            ?>
        </select></center>
    <br>
    <input type='submit' value='Valider' name='valider'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' value='Annuler' name='Annuler'>
    <br><br>
    <a href='?uc=attribChambres&action=demanderModifierAttrib'>Retour</a>
</form>     