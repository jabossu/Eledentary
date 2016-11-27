<?php


// ============= Donnees et Appels ===========

include("config.php") ; // contient les parametres de base du site, comme ceux de la base de donnee, ou encore son nom
include("init.php") ;	// contient les fonctions à appeller avant tout les reste, notamment la $bbd et les sessions.

// ============= Ajout des parties de pages ===========

// Ajoute tout le contenu des balises <head>
include("pages/parts/header_externe.php") ;
$_SESSION['langue'] = 'ro_RO' ;
include("langues/" . $_SESSION['langue'] . ".php" );

// "Purifie" les variables reçues.
$URL = 'http://www.' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ;

require( 'pages/reflecteurs/m_inscription_patient.php' ) ;
require( 'pages/afficheurs/v_inscription_patient.php' ) ;


echo '</body>' ;
