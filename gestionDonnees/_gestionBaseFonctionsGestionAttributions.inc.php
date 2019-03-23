<?

// FONCTIONS UTILISÉES UNIQUEMENT DANS LA GESTION DES ATTRIBUTIONS

// Met à jour (suppression, modification ou ajout) l'attribution correspondant à
// l'id étab, à l'id type chambre et à l'id groupe transmis
function modifierAttribChamb($idEtab,$idTypeChambre,$idGroupe,$nbChambres)
{
   global $connexion;
   $req="select count(*) as nombreAttribGroupe from Attribution where idEtab=
        '$idEtab' and idTypeChambre='$idTypeChambre' and idGroupe='$idGroupe'";
   $rsAttrib=mysql_query($req,$connexion);
   $lgAttrib=mysql_fetch_array($rsAttrib);
   if ($nbChambres==0)
      $req="delete from Attribution where idEtab='$idEtab' and 
           idTypeChambre='$idTypeChambre' and idGroupe='$idGroupe'";
   else
   {
      if ($lgAttrib["nombreAttribGroupe"]!=0)
         $req="update Attribution set nombreChambres=$nbChambres where idEtab=
              '$idEtab' and idTypeChambre='$idTypeChambre' and idGroupe=
              '$idGroupe'";
      else
         $req="insert into Attribution values('$idEtab','$idTypeChambre',
              '$idGroupe',$nbChambres)";
   }
   mysql_query($req,$connexion);
}

// Retourne la requête permettant d'obtenir les id et noms des groupes 
// affectés dans l'établissement transmis
function obtenirReqGroupesEtab($id)
{
   $req="select distinct id, nom from Groupe, Attribution where 
        Attribution.idGroupe=Groupe.id and idEtab='$id'";
   return $req;
}

// Retourne le nombre de chambres libres pour l'établissement et le type de
// chambre en question (retournera 0 si absence d'offre ou si absence de 
// disponibilité)  
function obtenirNbDispo($idEtab, $idTypeChambre)
{
   $nbOffre=obtenirNbOffre($idEtab,$idTypeChambre);
   if ($nbOffre!=0)
   {
      // Recherche du nombre de chambres occupées pour l'établissement et le
      // type de chambre en question
      $nbOccup=obtenirNbOccup($idEtab,$idTypeChambre);
      // Calcul du nombre de chambres libres
      $nbChLib=$nbOffre - $nbOccup;
      return $nbChLib;
   }
   else
      return 0;
}
            
// Retourne le nombre de chambres occupées par le groupe transmis pour l'id étab
// et l'id type chambre transmis
function obtenirNbOccupGroupe($idEtab, $idTypeChambre, $idGroupe)
{
   global $connexion;
   $req="select nombreChambres From Attribution where idEtab='$idEtab' and 
        idTypeChambre='$idTypeChambre' and idGroupe='$idGroupe'";
   $rsAttribGroupe=mysql_query($req, $connexion);
   if ($lgAttribGroupe=mysql_fetch_array($rsAttribGroupe))
      return $lgAttribGroupe["nombreChambres"];
   else
      return 0;
}

?>
