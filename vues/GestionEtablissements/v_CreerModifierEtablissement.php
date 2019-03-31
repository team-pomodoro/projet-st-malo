<?php
// CRÉER OU MODIFIER UN ÉTABLISSEMENT 

?>
<form method="POST" action="?uc=gestEtabs&action=<?= $action ?>">
    <br>
    <table width="85%" cellspacing="0" cellpadding="0" class="tabNonQuadrille">

        <tr class="enTeteTabNonQuad">
            <td colspan="3"><strong><?= $message ?></strong></td>
        </tr>
        <?php
        // En cas de création, l'id est accessible sinon l'id est dans un champ
        // caché               
        if ($creation) {
            // On utilise les guillemets comme délimiteur de champ dans l'echo afin
            // de ne pas perdre les éventuelles quotes saisies (même si les quotes
            // ne sont pas acceptées dans l'id, on a le souci de ré-afficher l'id
            // tel qu'il a été saisi) 

            ?>
            <tr class="ligneTabNonQuad">
                <td> Id*: </td>
                <td><input type="text" value="<?= (!isset($unEtab->id)) ? '' : $unEtab->id ?>" name="id" size ="10" 
                           maxlength="8"></td>
            </tr>
            <?php
        } else {

            ?>
            <tr>
                <td><input type="hidden" value="<?= (!isset($unEtab->id)) ? '' : $unEtab->id ?>" name="id"></td><td></td>
            </tr>
            <?php
        }

        ?>
        <tr class="ligneTabNonQuad">
            <td> Nom*: </td>
            <td><input type="text" value="<?= (!isset($unEtab->nom)) ? '' : $unEtab->nom ?>" name="nom" size="50" 
                       maxlength="45"></td>
        </tr>
        <tr class="ligneTabNonQuad">
            <td> Adresse*: </td>
            <td><input type="text" value="<?= (!isset($unEtab->adresseRue)) ? '' : $unEtab->adresseRue ?>" name="adresseRue" 
                       size="50" maxlength="45"></td>
        </tr>
        <tr class="ligneTabNonQuad">
            <td> Code postal*: </td>
            <td><input type="text" value="<?= (!isset($unEtab->codePostal)) ? '' : $unEtab->codePostal ?>" name="codePostal" 
                       size="7" maxlength="5"></td>
        </tr>
        <tr class="ligneTabNonQuad">
            <td> Ville*: </td>
            <td><input type="text" value="<?= (!isset($unEtab->ville)) ? '' : $unEtab->ville ?>" name="ville" size="40" 
                       maxlength="35"></td>
        </tr>
        <tr class="ligneTabNonQuad">
            <td> Téléphone*: </td>
            <td><input type="text" value="<?= (!isset($unEtab->tel)) ? '' : $unEtab->tel ?>" name="tel" size ="20" 
                       maxlength="10"></td>
        </tr>
        <tr class="ligneTabNonQuad">
            <td> E-mail: </td>
            <td><input type="text" value="<?= (!isset($unEtab->adresseElectronique)) ? '' : $unEtab->adresseElectronique ?>" name=
                       "adresseElectronique" size ="75" maxlength="70"></td>
        </tr>
        <tr class="ligneTabNonQuad">
            <td> Type*: </td>
            <td>
                <?php
                if (isset($unEtab->type) && $unEtab->type === 1) {

                    ?>
                    <input type="radio" name="type" value="1" checked>  
                    Etablissement Scolaire
                    <input type="radio" name="type" value="0">  Autre
                    <?php
                } else {

                    ?>
                    <input type="radio" name="type" value="1"> 
                    Etablissement Scolaire
                    <input type="radio" name="type" value="0" checked> Autre
                    <?php
                }

                ?>
            </td>
        </tr>
        <tr class="ligneTabNonQuad">
            <td colspan="2" ><strong>Responsable:</strong></td>

        </tr>
        <tr class='ligneTabNonQuad'>
            <td> Civilité*: </td>
            <td> <select name="civiliteResponsable">
                    <?php
                    for ($i = 0; $i < 3; $i = $i + 1) {
                        if (isset($unEtab->civiliteResponsable) && $tabCivilite[$i] === $unEtab->civiliteResponsable) {

                            ?>
                            <option selected><?= $tabCivilite[$i] ?></option>
                            <?php
                        } else {

                            ?>
                            <option><?= $tabCivilite[$i] ?></option>
                            <?php
                        }
                    }

                    ?>
                </select>&nbsp; &nbsp; &nbsp; &nbsp; Nom*: 
                <input type="text" value="<?= (!isset($unEtab->nomResponsable)) ? '' : $unEtab->nomResponsable ?>" name="nomResponsable" size="26" maxlength="25">
                &nbsp; &nbsp; &nbsp; &nbsp; Prénom: 
                <input type="text"  value="<?= (!isset($unEtab->prenomResponsable)) ? '' : $unEtab->prenomResponsable ?>" name="prenomResponsable" size="26" maxlength="25">
            </td>
        </tr>
    </table>
    <table align="center" cellspacing="15" cellpadding="0">
        <tr>
            <td align="right"><input type="submit" value="Valider" name="valider">
            </td>
            <td align="left"><input type="reset" value="Annuler" name="annuler">
            </td>
        </tr>
    </table>
    <a href="?uc=gestEtabs">Retour</a>
</form>

