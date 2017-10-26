<?php
//date_default_timezone_set('Europe/Bucharest') ;

//================================-
// Connexion à la base de données
//================================-
$bdd = new PDO(
	"mysql:host=$DB_HOST;dbname=$DB_NAME",
	"$DB_USER",
	"$DB_PASSWORD"
);
$GLOBALS['bdd'] = $bdd ;
error_reporting(0) ;

//================================-
// Autoload des classes
//================================-
function chargerClasse($classe)
// On inclut la classe correspondante au paramètre passé.
{	require_once 'classes/' . $classe . '.class.php' ; }
// On enregistre la fonction en autoload pour qu'elle soit appellée à chaque classe non déclarée.
spl_autoload_register('chargerClasse'); 


//================================-
// Création de la session
//================================-
session_start() ;

//================================-
// Inclusion des fonctions
//================================-
require_once('ressources/bbcode.php') ;
require_once('ressources/smileys.php') ;

require_once('fonctions/textuelles.php') ;
require_once('fonctions/testsTools.php') ;
require_once('fonctions/debug.php') ;
require_once('fonctions/datasManip.php') ;
require_once('fonctions/mails.php') ;
require_once('fonctions/f_bbcode.php') ;

if ( isset( $_SESSION['profile'] ) ) 
{
	$em = new elevesManager($bdd) ;
	 $_SESSION['profile'] = $em->get(  $_SESSION['profile']->id() ) ;
}

$cm = new siteconfigManager($bdd) ;
$siteconfig = $cm->get() ;

//================================-
// Language Definition
//================================-
if ( isset( $_GET['langue'] ) AND in_array($_GET['langue'], $listelangues ) )
// Si une nouvelle langue est demandée et qu'elle est autorisée dans config.php
{
	$_SESSION['langue'] = $_GET['langue'] ; # On change la langue utilisée
}

if ( !isset( $_SESSION['langue'] ) )
// Si aucune langue n'a été choisie pour le moment, on utilise celle par défaut
{	$_SESSION['langue'] = $siteconfig->websiteLanguage() ;	}

// On utilise cette langue
$traduction = loadTraduction($_SESSION['langue']);
