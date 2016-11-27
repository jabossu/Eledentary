<?php

$pm = new pathologiesManager($bdd) ;


$errorType = 0 ;
/*
*	0 : pas d'erreur, on affiche la page pour la première fois.
*/
$successType = 0 ;

foreach ($_POST['annees'] as $key => $value)
{
	$_POST['annees'][$key] = strip_tags($value) ;
}
clean($_GET) ;

if ( isset( $_GET['id'] ) and $pm->existe($_GET['id']) )
{
	if ( isset( $_GET['action'] ) and $_GET['action'] == 'delete' )
	{
		$mode = 'delete' ;
		$p = $pm->get($_GET['id']) ;
	}
	else
	{
		$mode = 'edit' ;
		$p = $pm->get($_GET['id']) ;
	}
}
else
{
	$mode = 'create' ;
	$p = new pathologie($_POST) ;
}

if ( $p->nom('fr_FR') != null and $p->details('fr_FR') != null and $p->nom('en_EN') != null and $p->details('en_EN') != null and $p->annees() != null )
{
	if ($mode == 'create')
	{
		$successType = 1 ;
		$pm->add($p) ;
		log_add($_SESSION['profile']->id(), 'New Pathologie', 'Pathologie <b>'.$p->nom('en_EN').'</b> was created.') ;
		$p = new pathologie(array()) ;
	}
	elseif ( $mode == 'edit' )
	{
		if ( !missing_keys( $_POST, array('nom_fr_FR', 'nom_en_EN', 'details_fr_FR', 'details_en_EN', 'annees') ) )
		{
			$successType = 2 ;
			$p = new pathologie($_POST) ;
			$p->setId($_GET['id']) ;
			$pm->update($p) ;
			log_add($_SESSION['profile']->id(), 'Edit Pathologie', 'Pathologie <b>'.$p->nom('en_EN').'</b> was modified.') ;
		}
		elseif (missing_keys( $_POST, array('nom', 'details', 'annees') ) != array('nom', 'details', 'annees') )
		{
			show( missing_keys( $_POST, array('nom', 'details', 'annees') ) ) ;
			show( $_POST ) ;
			$errorType = 1 ;
		}
	}
	elseif ( $mode == 'delete' )
	{
		$pm->remove( $p->id() );
		$successType = 3 ;
		log_add($_SESSION['profile']->id(), 'Remove Pathologie', 'Pathologie <b>'.$p->nom('en_EN').'</b> was deleted.') ;
		$p = new pathologie(array()) ;
	}
}
elseif ( $p->nom('en_EN') != null or $p->details('en_EN') != null or $p->nom('fr_FR') != null or $p->details('fr_FR') != null or $p->p_annees() != null )
{
	$errorType = 1 ;
}

