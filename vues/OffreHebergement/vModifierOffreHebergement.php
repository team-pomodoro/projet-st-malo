<?
include("_debut.inc.php");

// MODIFIER LES OFFRES DE L'ÉTABLISSEMENT SÉLECTIONNÉ

echo "
<form method='POST' action='cOffreHebergement.php'>
   <input type='hidden' value='validerModifierOffre' name='action'>";

   $lgEtab=obtenirDetailEtablissement($idEtab);
   
   // $i va permettre de manipuler le tableau $nbChambres qui contient 
   // les offres de chambres relatives à tous les types de chambres pour 
   // l'établissement en question
   // $nbChambres[0] contiendra le nombre de chambres pour le 1er type de 
   // chambre, $nbChambres[1] contiendra le nombre de chambres pour le 2ème type  
   // de chambre...
   $i=0;

   $nom=$lgEtab['nom'];
   
   // AFFICHAGE DU NOM DE L'ÉTABLISSEMENT
   echo "<br><strong>$nom</strong><br><br>
      
   <table width='45%' cellspacing='0' cellpadding='0' class='tabQuadrille'>";
      
      // AFFICHAGE DE LA LIGNE D'EN-TÊTE
      echo "
      <tr class='enTeteTabQuad'>
         <td width='30%'>Type</td>
         <td width='37%'>Capacité</td>
         <td width='33%'>Nombre de chambres</td> 
      </tr>";
      
      $req=obtenirReqTypesChambres();
      $rsTypeChambre=mysql_query($req,$connexion);
      
      // BOUCLE SUR LES TYPES DE CHAMBRES (AFFICHAGE D'UNE LIGNE PAR TYPE DE 
      // CHAMBRE AVEC EN 3ÈME COLONNE LE NOMBRE DE CHAMBRES OFFERTES DANS
      // L'ÉTABLISSEMENT POUR LE TYPE DE CHAMBRE OU LA VALEUR EN ERREUR LE CAS
      // ÉCHÉANT)
      while ($lgTypeChambre=mysql_fetch_array($rsTypeChambre))    
      {
         $idTypeChambre=$lgTypeChambre['id'];
         $libelle=$lgTypeChambre['libelle'];
            
         echo "
         <tr class='ligneTabQuad'>
            <td>$idTypeChambre</td>
            <td>$libelle</td>";
            
            // AFFICHAGE DE LA CELLULE NOMBRE DE CHAMBRES OFFERTES
            // Si on "vient" de ce formulaire (action 'validerModifierOffre') et
            // que le nombre de chambres pour le type en question est en erreur,
            // ce nombre est affiché en erreur
            if ($action=='validerModifierOffre' && (!estEntier($nbChambres[$i])
            || !estModifOffreCorrecte($idEtab,$idTypeChambre,$nbChambres[$i])))
            {
               echo "
               <td align='center'><input type='text' value='$nbChambres[$i]' 
               name='nbChambres[$i]' maxlength='3' class='erreur'></td>";
            }
            else
            {
               // Appel à la fonction obtenirNbOffre pour récupérer le nombre
               // de chambres offertes
               $nbOffre=obtenirNbOffre($idEtab,$idTypeChambre);
               echo "
               <td align='center'><input type='text' value='$nbOffre' 
               name='nbChambres[$i]' maxlength='3'></td>";
            }
            // Le tableau des différents $idTypeChambre est nécessaire à
            // cOffreHebergement.php donc on le transmet en champs cachés
            echo "
            <input type='hidden' value='$idTypeChambre' 
            name='idTypeChambre[$i]'>
         </tr>";
         $i=$i+1;
      } // Fin de la boucle sur les types de chambres
   echo  
   "</table>";
   
   // La variable $idEtab et le nombre de lignes du tableau (qui est en fait le
   // nombre de types de chambres) sont nécessaires àcOffreHebergement.php donc 
   // on les transmet en champs cachés
   echo "
   <input type='hidden' value='$idEtab' name='idEtab'>    
   <input type='hidden' value='$i' name='nbLignes'>
   
   <table align='center' cellspacing='15' cellpadding='0'>
      <tr>
         <td align='right'><input type='submit' value='Valider' 
         name='validerModifierOffre'></td>
         <td align='left'><input type='reset' value='Annuler' name='annuler'>
         </td>
      </tr>
   </table>
   <a href='cOffreHebergement.php?'>Retour</a>
</form>";

include("_fin.inc.php");
?>
