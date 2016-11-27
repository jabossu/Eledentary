<?php

classe('o', 'page-header' ) ;
display( 'page_contact', 'h1' ) ;
classe('c') ;

switch ($errorType)
{
	case '1':
		alerte('bad_infos', 'danger');
	break;
	
	case '2':
		$chaine = translate('error_msg_missing_infos', 'strong') ;
		foreach (contains_null($_POST) as $value)
		{
			$chaine = $chaine . ' ' . translate($value) . ' ; ' ;
		}
		alerte($chaine, 'warning', '', false) ;
	break;
	
	case '3':
		$chaine = translate('error_msg_incorrect_infos', 'strong') ;
		foreach (contains_null($donnees) as $value)
		{
			$chaine = $chaine . ' ' . translate($value) . ' ;';
		}
		alerte($chaine, 'warning', '', false) ;
	break;
}
switch ($successType)
{
	case '1':
		alerte('success_msg_send', 'success') ;
	break;
}

$f = new form('welled', 'write_message') ;

$f->input('objet', null, 'text', $_POST['objet'], null, translate('msg_objet')) ;
$f->textarea('corps', translate('msg_corps'), $_POST['corps']) ;

$f->submit( translate('msg_send') ) ;

$f->output() ;
