<?php


$errorType = 0 ;


$em = new elevesManager($bdd) ;

if ( isset( $_GET['year'] ) )
{
	$_GET['year'] = strip_tags( $_GET['year'] ) ;
	$y = preg_match( '#[03-6]#', $_GET['year'] ) ? $_GET['year'] : 0 ;
}
else
{
	$y = 0 ;
}

if ( isset( $_GET['role'] ) )
{
	$_GET['role'] = strip_tags( $_GET['role'] ) ;
	if ( in_array( $_GET['role'], array('administrateur', 'approuve', 'nouveau', 'banni', 'all')  )  )
	{
		$r = $_GET['role'] ;
	}
	else
	{
		$r = 'all' ;
	}
}
else
{
	$r = 'all' ;
}
$liste_eleves = $em->getList($y, $r) ;

