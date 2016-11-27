<?php

$errorType = 0  ;
/*	0 = Formulaire rempli et correcte
*	1 = Formulaire  vierge
*	2 = Formulaire incohérent
*	3 = Formulaire incomplet
*	4 = Des valeurs sont incorectes
*	5 = Le matricule est double !
*/

// Liste des parametre que l'on s'attend à recevoir.
$parametresAttendus = array('fr_titre', 'en_titre', 'fr_contenu', 'en_contenu');

$dm = new dentissimoManager($bdd) ;

clean($_GET) ;
if (	isset( $_GET['action'] ) AND $_GET['action'] == 'edit' AND
		isset( $_GET['id'] ) AND $dm->existeId( $_GET['id'] ) )
{	$mode = 'edit' ;
	$donnee['id'] 			= $_GET['id'] ;
}
elseif (isset( $_GET['action'] ) AND $_GET['action'] == 'delete' AND
		isset( $_GET['id'] ) AND $dm->existeId( $_GET['id'] ))
{
	$mode = 'delete' ;
}
else
{	$mode = 'create' ;	}

// On charge l'article à éditer pour l'afficher dans le formulaire.
if ( $mode == 'edit' )
{
	if ( contains_null($_POST) or missing_keys($_POST, $parametresAttendus) )
	{
		$tmpNews = $dm->get($_GET['id']) ;
		$donnee['fr_titre'] 		= $tmpNews->titre('fr_FR') ;
		$donnee['fr_contenu'] 		= strip_tags( $tmpNews->contenu('fr_FR') ) ;
		$donnee['en_titre']			= $tmpNews->titre('en_EN') ;
		$donnee['en_contenu'] 		= strip_tags( $tmpNews->contenu('en_EN') ) ;
	}
	else
	{
		clean($_POST) ;
		$donnee['fr_titre'] 		=	$_POST['fr_titre'];
		$donnee['fr_contenu'] 		=	$_POST['fr_contenu'];
		$donnee['en_titre']			=	$_POST['en_titre']; 
		$donnee['en_contenu'] 		=	$_POST['en_contenu'];
	}
}


if ($mode == 'delete')
{
	$tmpNews = $dm->get($_GET['id']) ;
	$dm->delete($tmpNews) ;
	// Pas vraiment une erreur, mais on utilise
	// Cette variable pour afficher le succès ensuite.
	$errorType = 4 ;
}
else
{
	// On "purifie" les infos reçue avec un strip_tags
	clean($_POST) ;

	// Si il manque des clefs, ou bien le POST n'est pas rempli du tout, ou bien il est incomplet.
	if ( missing_keys($_POST, $parametresAttendus) )
	{
		// Il manque toutes les clefs : la page est affichée pour la première fois
		if ( missing_keys($_POST, $parametresAttendus) == $parametresAttendus )
		{
			$errorType = 1 ;
		}
		// Il ne manque que certaines clefs : le POST est incohérent.
		else
		{
			$errorType = 2 ;
		}
	}
	// Il ne manque aucune clef : le POST est bien reçu.
	else
	{	
		if ( $mode == 'create' )
		{
			$donnee['fr_titre'] = $_POST['fr_titre'] ;
			$donnee['en_titre'] = $_POST['en_titre'] ;
	
			$donnee['fr_contenu'] = $_POST['fr_contenu'] ;
			$donnee['en_contenu'] = $_POST['en_contenu'] ;
		}

		// Il peut manquer des valeurs dans $_POST
		if ( contains_null($_POST) )
		{
			$errorType = 3 ;
		}
		// Toutes les valeurs sont là : il faut les filter
		else
		{	
			$article = new dentissimo($donnee) ;
			if ( $mode == 'create' )
			{
				$dm->add($article) ;
                log_add($_SESSION['profile']->id(), 'New wikipage posted', 'Wrote an wikipage named <i>' . $article->titre('en_EN') . '</i>' ) ;
				unset($_POST) ;
			}
			elseif ( $mode == 'edit' )
			{
				$dm->update($article) ;
                log_add($_SESSION['profile']->id(), 'Wikipage edited', 'Edition of the wikipage #' . $_GET['id'] . ' named <i>' . $article->titre('en_EN') . '</i>' ) ;
				$errorType = 0 ;
			}
		}
	}
}
