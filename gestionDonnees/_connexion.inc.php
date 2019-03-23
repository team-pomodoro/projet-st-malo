<?

$hote="localhost";
$login="festival";
$mdp="secret";
$bd="festival";
$connexion=mysql_connect($hote,$login,$mdp);
if ($connexion) 
{
   $query="SET CHARACTER SET utf8";
   // modification du jeu de caractères de la connexion
   $res=mysql_query($query, $connexion); 
   mysql_select_db($bd, $connexion);
}
else 
{
   ajouterErreur("Echec de la connexion au serveur MySQL");
   ajouterErreur(" => " . mysql_error());
} 

?>
