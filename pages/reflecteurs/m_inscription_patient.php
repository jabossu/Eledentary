<?php


$errorType = 0 ;
/*
*	1 : Incorrect form
*	2 : Missing infos
*/

clean($_POST) ;
clean($_GET) ;

$pm = new patientsManager($bdd) ;
$p = new patient( array() ) ;

$mode = 'create' ;

$valeursAttendues = array('nom', 'prenom', 'cnp', 'details', 'telephone', 'email', 'addresse') ;
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
	elseif ( $mode == 'edit' )
	{
		$p = $pm->get($_GET['id']);
	}
}

if ( $p->nom() != null
		AND $p->prenom() != null
		AND $p->cnp() != null
		AND ( $p->email() != null OR $p->telephone() != null OR $p->addresse() != null ) )
{
	if ( $mode == 'create' and $init != true )
	{
		$p->setId_patho(1) ;
		$p->setDent(00) ;
		$pm->add($p) ;
		log_add($_SESSION['profile']->id(), 'Patient Added', $p->nom() . ' was registered as patient #' . $p->id() ) ;
		mailPatient($p, 'Inscription réussie', 'inscription_confirmpatient') ;
		$successType = 1 ;
		$p = new patient(array() );
	}
	elseif ( $mode == 'edit' and $init != true )
	{
		$pm->update($p) ;
		log_add($_SESSION['profile']->id(), 'Patient Modified', $p->nom() . ' was modified as patient #' . $p->id() ) ;
		$successType = 2 ;
	}
}
else
{
	$errorType = 2 ;
}
