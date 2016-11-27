<?php

$errorType = 0 ;
/*
*	1	:	le message n'existe pas : id invalide.
*/

clean($_GET) ;
$id = $_GET['id'] ;
$mm = new messagesManager($bdd) ;


if ( $mm->existeId($id) == false )
{
	$errorType = 1 ;
}
else
{
	$m = $mm->get($id) ;
	switch ($_GET['action'])
	{
		case 'markread':
			$mm->markRead($m) ;
			$m->setEtat('lu') ;
		break;
	
		case 'markunread':
			$mm->markUnread($m) ;
			$m->setEtat('nonlu') ;
		break;
	}
}


