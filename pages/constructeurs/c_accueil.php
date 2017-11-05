<?php

$successDeco= false ;
if ( isset( $_SESSION['profile'] ) AND isset( $_GET['action'] ) AND $_GET['action'] == 'logout' )
{
	unset($_SESSION['profile']);
	$successDeco= true ;
	header('Location: /?page=accueil');
}


/*
*	admins 		= 40
*	legitimate	= 35
*	connected	= 30
*	everyone	= 20
*	visitors	= 10
*/

$accesslevel = 10 ;

