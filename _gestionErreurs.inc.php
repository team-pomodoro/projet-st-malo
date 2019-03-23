<?

// Si la valeur transmise ne contient pas d'autres caractères que des chiffres, 
// la fonction retourne vrai
function estEntier($valeur)
{
   return !ereg("[^0-9]",$valeur);
}

// Si la valeur transmise ne contient pas d'autres caractères que des chiffres  
// et des lettres non accentuées, la fonction retourne vrai
function estChiffresOuEtLettres($valeur)
{
   return !ereg("[^a-zA-Z0-9]",$valeur);
}

function razErreurs() 
{
   unset($_REQUEST['erreurs']);
}
 
function ajouterErreur($msg)
{
   if (! isset($_REQUEST['erreurs']))
      $_REQUEST['erreurs']=array();
   $_REQUEST['erreurs'][]=htmlentities($msg,ENT_QUOTES,'UTF-8');
}
 
function getErreurs()
{
   if (!isset($_REQUEST['erreurs']))
      $_REQUEST['erreurs']= array();
   return $_REQUEST['erreurs'];
}

function nbErreurs()
{
   return count(getErreurs());
}
 
function printErreurs()
{
   if (nbErreurs()!=0)
   {
      echo '<div id="erreur" class="msgErreur">';
      echo '<ul>';
      foreach (getErreurs() as $erreur)
      {
         echo "<li>$erreur</li>";
      }
      echo '</ul>';
      echo '</div>';
   }
} 

?>
