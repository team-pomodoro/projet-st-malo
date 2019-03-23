<?
include("_debut.inc.php");

// OBTENIR LE DÉTAIL DE L'ÉTABLISSEMENT SÉLECTIONNÉ

$lgEtab=obtenirDetailEtablissement($id);

$nom=$lgEtab['nom'];
$adresseRue=$lgEtab['adresseRue'];
$codePostal=$lgEtab['codePostal'];
$ville=$lgEtab['ville'];
$tel=$lgEtab['tel'];
$adresseElectronique=$lgEtab['adresseElectronique'];
$type=$lgEtab['type'];
$civiliteResponsable=$lgEtab['civiliteResponsable'];
$nomResponsable=$lgEtab['nomResponsable'];
$prenomResponsable=$lgEtab['prenomResponsable'];

echo "
<br>
<table width='60%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
   
   <tr class='enTeteTabNonQuad'>
      <td colspan='3'><strong>$nom</strong></td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td  width='20%'> Id: </td>
      <td>$id</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Adresse: </td>
      <td>$adresseRue</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Code postal: </td>
      <td>$codePostal</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Ville: </td>
      <td>$ville</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Téléphone: </td>
      <td>$tel</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> E-mail: </td>
      <td>$adresseElectronique</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Type: </td>";
      if ($type==1)
      {
         echo "<td> Etablissement scolaire </td>";
      }
      else
      {
         echo "<td> Autre établissement </td>";
      }
   echo "
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Responsable: </td>
      <td>$civiliteResponsable&nbsp; $nomResponsable&nbsp; $prenomResponsable
      </td>
   </tr> 
</table>
<br>
<a href='cGestionEtablissements.php'>Retour</a>";

include("_fin.inc.php");
?>
