<?php

$errorType = 0 ;
/*
*	1	:	formulaire corrompu.
*	2	:	il existe des champs vides
*	3	:	Certains champs sont mal remplis
*/
$successType = 0 ;
/*
*	0	:	formulaire vide
*	1	:	ajout réussi
*/

$mm = new messagesManager($bdd) ;

clean($_POST);
$parametresAttendus = array( 'objet', 'corps' );

if (missing_keys($_POST, $parametresAttendus) )
{
	if (missing_keys($_POST, $parametresAttendus) != $parametresAttendus)
	{
		$errorType = 1 ;
	}
}
else
{
	if ( contains_null($_POST) )
	{
		$errorType = 2 ;
	}
	else
	{
		$donnees['expediteur']		=	$_SESSION['profile']->id();
		$donnees['objet']			=	preg_match( '#^.{4,250}$#i'			, $_POST['objet']) ? $_POST['objet'] : null ;
		$donnees['corps']			=	preg_match( "#^.|[\n]{20,20000}$#i"		, $_POST['corps']) ? $_POST['corps'] : null ;
	
		if (contains_null($donnees) )
		{
			$errorType = 3;
		}
		else
		{
			$m = new message($donnees) ;
			$mm->writeMessage($m) ;
            log_add($_SESSION['profile']->id(), 'Message send', 'Student #' . $_SESSION['profile']->id() . ' named ' . $_SESSION['profile']->nom() . ' ' . $_SESSION['profile']->prenom() . ' wrote a message to admins') ;
			$successType = 1 ;
			unset($_POST) ;
		}
	}
}
