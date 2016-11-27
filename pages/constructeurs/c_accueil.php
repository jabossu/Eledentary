<?php

if ( isset( $_SESSION['profile'] ) AND isset( $_GET ) AND $_GET['action'] == 'logout' )
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

$accesslevel == 10 ;

