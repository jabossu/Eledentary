<?php


$errorType = 0 ;
/*
*	1 : Incorrect form
*	2 : Missing infos
*	3 : patient already has a medic
*	4 : Medic already has a patient
*	5 : patient cannot be freed
*/

clean($_POST) ;
clean($_GET) ;

$pm = new patientsManager($bdd) ;
$p = new patient( array() ) ;


if ( isset( $_GET['id'] ) and $pm->existe($_GET['id']) )
{
	if ( isset( $_GET['action'] ) )
	{
		if ( $_GET['action'] == 'delete' )
		{ $mode = 'delete' ; }
		elseif ( $_GET['action'] == 'reserve' )
		{ $mode = 'reserve' ; }
		elseif ( $_GET['action'] == 'free' )
		{ $mode = 'free' ; }
	}
	else
	{ $mode = 'edit' ; }
}
else
{
	$mode = 'create' ;
}

$valeursAttendues = array('nom', 'prenom', 'cnp', 'id_patho', 'dent', 'details', 'telephone', 'email', 'addresse') ;
if ( missing_keys($_POST, $valeursAttendues) == false )
{
	$init = false ;
	
	if ( $mode == 'create' )
	{
		$p = new patient( $_POST );
	}
	elseif ( $mode == 'edit' )
	{
		$p = new patient( $_POST );
		$p->setId($_GET['id']) ;
	}
}

else
{
	$init = true ;
	
	if ( missing_keys($_POST, $valeursAttendues) != $valeursAttendues )
	{
		$errorType = 1 ;
	}
	if ( $mode == 'create' )
	{
		$p = new patient(array());
	}
	elseif ( $mode == 'edit' or $mode == 'reserve' or $mode == 'delete' or $mode == 'free' )
	{
		$p = $pm->get($_GET['id']);
	}
}

if ( $p->nom() != null
		AND $p->prenom() != null
		AND $p->cnp() != null
		AND $p->dent() != null
		AND $p->id_patho() != null
		AND ( $p->email() != null OR $p->telephone() != null OR $p->addresse() != null ) )
{
	if ( $mode == 'create' and $init != true )
	{
		$pm->add($p) ;
		log_add($_SESSION['profile']->id(), 'Patient Added', $p->nom() . ' was registered as patient #' . $p->id() ) ;
		$successType = 1 ;
		$p = new patient(array() );
	}
	elseif ( $mode == 'edit' and $init != true )
	{
		$pm->update($p) ;
		log_add($_SESSION['profile']->id(), 'Patient Modified', $p->nom() . ' was modified as patient #' . $p->id() ) ;
		$successType = 2 ;
	}
	elseif ( $mode == 'delete' and $_SESSION['profile']->statut() == 'administrateur' )
	{
		$pm->delete($p) ; 
		log_add($_SESSION['profile']->id(), 'Patient Deleted', $p->nom() . ' was deleted (patient #' . $p->id() . ')' ) ;
		$successType = 3 ;
		$p = new patient(array() );
	}
	elseif ( $mode == 'reserve' )
	{
		$em = new elevesManager($bdd) ;
		$e = $_SESSION['profile'] ;
		if ($em->hasReserved($e) <= $siteconfig->patientLimit() )
		{
			if ($pm->isFree($p))
			{
				$pm->reserve($p, $e) ; 
				log_add($_SESSION['profile']->id(), 'Patient reserved', $e->nom() . ' ' . $e->prenom() . ' has reserved patient #' . $p->id() ) ;
				$successType = 4 ;
				$p = $pm->get($p->id()) ;
			}
			else
			{
				$errorType = 3 ;
			}
		}
		else
		{
			$errorType = 4 ;
		}
	}
	elseif ( $mode == 'free' )
	{
		$em = new elevesManager($bdd) ;
		$e = $_SESSION['profile'] ;
		
		if ( $e->id == $p->soignant() or $e->statut() == 'administrateur' )
		{
			$pm->free($p, $e) ; 
			log_add($_SESSION['profile']->id(), 'Patient freed', $e->nom() . ' ' . $e->prenom() . ' has freed patient #' . $p->id() ) ;
			$successType = 5 ;
			$p = $pm->get($p->id()) ;
		}
		else
		{
			$errorType = 5 ;
		}
		
	}
}
else
{
	$errorType = 2 ;
}
