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
$file = "langues/".$cur.".csv";

if (substr(sprintf('%o', fileperms($file)), -4) != "0666" ) 
{ $alertmessage = "<strong>Warning ! </strong>Traduction file is not writable"; }

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
// si le formulaire a été envoyé
{
	clean($_POST); # supprime tout code html contenu dans le formulaire

	foreach($_POST as $keyword => $value)
	{
		$alertmessage = "";
		try
		{
			if ( file_exists($file) )
			{
				$fw = fopen($file,"w");
				if($fw)
				{
					foreach ($_POST as $keyword => $line)
					{
						fputcsv($fw, array($keyword,$line), ';');
					}
					fclose($fw);
				}
				else
				{	throw new Exception('Writting file failed');	}
			}
			else 
			{
			    throw new Exception('File not found');
			}
			
		}
		catch(Exception $e)
		{
			$alertmessage = "<strong>Error while saving :</strong> ".$e->getMessage() ;
		}
	}
}

// Chargement des langues dans des tableaux
$langueRef = loadTraduction($ref);
$langueCur = loadTraduction($cur);
