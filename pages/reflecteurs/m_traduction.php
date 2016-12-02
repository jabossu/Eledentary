<?php

/**
*	REFLECTEUR DE LA PAGE TRADUCTIOn
*	
	0 - récupère le $_POST si il existe
	  - utilise le $_POST pour recréer les fichiers de traduction
	1 - lit les fichiers de traduction
	  - construit les array de langue
*
**/

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
// si le formulaire a été envoyé
{
	clean($_POST); # supprime tout code html contenu dans le formulaire
	
}
