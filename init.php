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


//================================-
// Autoload des classes
//================================-
function chargerClasse($classe)
// On inclut la classe correspondante au paramètre passé.
{	require 'classes/' . $classe . '.class.php' ; }
// On enregistre la fonction en autoload pour qu'elle soit appellée à chaque classe non déclarée.
spl_autoload_register('chargerClasse'); 


//================================-
// Création de la session
//================================-
session_start() ;

//================================-
// Inclusion des fonctions
//================================-
include('ressources/bbcode.php') ;
include('ressources/smileys.php') ;

include('fonctions/textuelles.php') ;
include('fonctions/testsTools.php') ;
include('fonctions/debug.php') ;
include('fonctions/datasManip.php') ;
include('fonctions/mails.php') ;
include('fonctions/f_bbcode.php') ;

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
{
	$_SESSION['langue'] = $_GET['langue'] ;
}

if ( !isset( $_SESSION['langue'] ) )
{	$_SESSION['langue'] = $siteconfig->websiteLanguage() ;	}

include("langues/" . $_SESSION['langue'] . ".php" );
