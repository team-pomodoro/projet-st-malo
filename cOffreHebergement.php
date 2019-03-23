<?

include("_gestionErreurs.inc.php");
include("gestionDonnees/_connexion.inc.php");
include("gestionDonnees/_gestionBaseFonctionsCommunes.inc.php"); 

// 1ère étape (donc pas d'action choisie) : affichage du tableau des offres en 
// lecture seule
if (! isset($_REQUEST['action'])) 
{   
   $_REQUEST['action']='initial'; 
}

$action=$_REQUEST['action'];

// Aiguillage selon l'étape   
switch ($action) 
{
   case 'initial' :
      include("vues/OffreHebergement/vConsulterOffreHebergement.php");
      break;
   
   case 'demanderModifierOffre':
      $idEtab=$_REQUEST['idEtab'];
      include("vues/OffreHebergement/vModifierOffreHebergement.php");
      break;
   
   case 'validerModifierOffre':
      $idEtab=$_REQUEST['idEtab'];
      $idTypeChambre=$_REQUEST['idTypeChambre'];
      $nbChambres=$_REQUEST['nbChambres'];
      $nbLignes=$_REQUEST['nbLignes'];
      $err=false;
      for ($i=0; $i<$nbLignes; $i=$i+1)
      {
         // Si la valeur saisie n'est pas numérique ou est inférieure aux 
         // attributions déjà effectuées pour cet établissement et ce type de
         // chambre, la modification n'est pas effectuée
         if (!estEntier($nbChambres[$i]) || !estModifOffreCorrecte
            ($idEtab,$idTypeChambre[$i],$nbChambres[$i]))
         {
            $err=true;
         }
         else
         {
            modifierOffreHebergement
            ($idEtab,$idTypeChambre[$i],$nbChambres[$i]);
         }
      }
      if ($err)
      {
         ajouterErreur (
         "Valeurs non entières ou inférieures aux attributions effectuées");
         include("vues/OffreHebergement/vModifierOffreHebergement.php");
      }
      else
      {
         include("vues/OffreHebergement/vConsulterOffreHebergement.php");
      }
      break;
}

// Fermeture de la connexion au serveur MySql
mysql_close();

?>
