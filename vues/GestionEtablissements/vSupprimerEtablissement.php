<?
include("_debut.inc.php");

// SUPPRIMER L'ÉTABLISSEMENT SÉLECTIONNÉ

$id=$_REQUEST['id'];  // Non obligatoire mais plus propre
$lgEtab=obtenirDetailEtablissement($id);
$nom=$lgEtab['nom'];
echo "
<br><center>Voulez-vous vraiment supprimer l'établissement $nom ?
<h3><br>
<a href='cGestionEtablissements.php?action=validerSupprimerEtab&id=$id'>Oui</a>
&nbsp; &nbsp; &nbsp; &nbsp;
<a href='cGestionEtablissements.php?'>Non</a></h3>
</center>";

include("_fin.inc.php");
?>
