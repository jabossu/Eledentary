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

// Quels sont les langues actuellement utilisées ?
$ref = $siteconfig->websiteLanguage() ;
$cur = $_SESSION['langue'] ;

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
// si le formulaire a été envoyé
{
	clean($_POST); # supprime tout code html contenu dans le formulaire

	foreach($_POST as $keyword => $value)
	{
		$file = fopen('langues/fr_FR.csv',"w+");
		if($file)
		{
			foreach ($_POST as $keyword => $line)
			{
				fputcsv($file, array($keyword,$line), ';');
			}
			fclose($file);
		}
		else
		{	exit("Critical error : file not found");	}
	}
}

// Chargement des langues dans des tableaux
$langueRef = loadTraduction($ref);
$langueCur = loadTraduction($cur);
