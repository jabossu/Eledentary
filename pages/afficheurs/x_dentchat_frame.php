<?php


include($_SERVER['DOCUMENT_ROOT'].'/config.php') ; 

$bdd = new PDO(
	"mysql:host=$DB_HOST;dbname=$DB_NAME",
	"$DB_USER",
	"$DB_PASSWORD"
);
$GLOBALS['bdd'] = $bdd ;

function chargerClasse($classe)
// On inclut la classe correspondante au paramètre passé. 

//HTTP-EQUIV="refresh"


{	require '../../classes/' . $classe . '.class.php' ; }
// On enregistre la fonction en autoload pour qu'elle soit appellée à chaque classe non déclarée.
spl_autoload_register('chargerClasse'); 

session_start() ;

if ( !isset( $_SESSION['langue'] ) )
{	$_SESSION['langue'] = 'fr_FR' ;	}
include("../../langues/" . $_SESSION['langue'] . ".php" );

require('../../ressources/bbcode.php') ;
require('../../ressources/smileys.php') ;

require('../../fonctions/textuelles.php') ;
require('../../fonctions/testsTools.php') ;
require('../../fonctions/datasManip.php') ;
require('../../fonctions/f_bbcode.php') ;

$cm = new chatsManager($bdd) ;

$messages = $cm->get() ;

$time = '00:00';
$day = 'YYY-MM-DD';
$username='---';
$pseudo = substr($_SESSION['profile']->nom(), 0, 6 ) ;
$nom = $_SESSION['profile']->nom() ;
$prenom = $_SESSION['profile']->prenom() ;
foreach ($messages as $k => $v)
{
	if (preg_match("#$pseudo|$nom|$prenom#i", $v->message() ) )
	{
		$focus = true ;
	}
	else
	{
		$focus = false ;
	}
	
	
	if ($day != $v->day() )
	{		echo '<h5><span>' . $v->day() . '</span></h5>' ;	}
	
	if ($v->userid() == $_SESSION['profile']->id() )
	{
		$color = 'grey' ;
	}
	elseif ( $focus == true)
	{
		$color = 'green' ;
	}
	else
	{		
		$color = 'black' ;	
	}
		
	echo "<div style='color: $color;'>" ;
	classe('o', 'row');
	
	classe('o', 'col-xs-1');
	if ( $v->time() != $time )
	{	
		echo "<b>" . $v->time() . "</b>" ;
	}
	classe('c');
	classe('o', 'col-xs-2');
	if ( $v->username() != $username or $v->time() != $time )
	{
		if ( $focus == true )
		{
			 echo '<span class="glyphicon glyphicon-alert"></span>  ' ;
		}
		echo "<small><strong>" . $v->username() . "</strong></small> :<br/>" . translate($v->anneeuser()) . "</br>" ;
	}
	classe('c');
	
	classe('o', 'col-xs-5');
	echo bbdecode($v->message()) ;
	
	classe('c');
	classe('c') ;
	echo '</div>';
	$username = $v->username() ;
	$time = $v->time() ;
	$day = $v->day() ;
}

?>
